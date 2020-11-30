<?php

namespace GFExcel\Renderer;

use GFExcel\Exception\Exception as GFExcelException;
use GFExcel\GFExcel;
use GFExcel\Values\BaseValue;
use GFExcel\Values\NumericValue;
use GFForms;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Writer\BaseWriter;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

/**
 * The base for a {@see PhpSpreadsheet} renderer.
 */
abstract class AbstractPHPExcelRenderer extends AbstractRenderer
{
    /** @var Spreadsheet */
    protected $spreadsheet;

    /**
     * Creates an AbstractPHPExcelRenderer instance.
     */
    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        register_shutdown_function([$this, 'fatalHandler']);
    }

    /**
     * This is where the magic happens, and the actual file is being rendered.
     * @param string $extension
     * @param bool $save
     * @return string
     */
    public function renderOutput($extension = 'xlsx', $save = false)
    {
        $exception = null;
        try {
            $this->spreadsheet->setActiveSheetIndex(0);
            /** @var BaseWriter $objWriter */
            $objWriter = IOFactory::createWriter($this->spreadsheet, ucfirst($extension));
            $objWriter->setPreCalculateFormulas(false);

            if ($objWriter instanceof Csv) {
                $this->setCsvProperties($objWriter);
            }

            if ($save) {
                $file = get_temp_dir() . $this->getFileName();
                $objWriter->save($file);

                return $file;
            }

            if ($extension === 'xlsx') {
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            } elseif ($extension === 'csv') {
                header('Content-Type: text/csv');
            }

            header('Content-Disposition: attachment;filename="' . $this->getFileName() . '"');
            header('Cache-Control: max-age=1');

            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            header('X-Robots-Tag: noindex, nofollow'); // HTTP/1.0

            if (ob_get_length()) {
                ob_end_clean(); // Cleaning buffer for preventing file corruption
            }

            $objWriter->save('php://output');
        } catch (\Exception $e) {
            //in case of php5.x
            $exception = $e;
        } catch (\Throwable $e) {
            $exception = $e;
        }

        if ($exception) {
            header('Content-Type: text/html');
            header_remove('Content-Disposition');
            $this->handleException($exception);
        }

        exit; // stop rest
    }

    /**
     * Handle fatal error during execution
     * @throws \Exception
     */
    public function fatalHandler()
    {
        $error = error_get_last();
        if ($error['type'] === E_ERROR) {
            $exception = new \Exception($error['message']);
            $this->handleException($exception);
        }
    }

    /**
     * Stretches all columns to the maximum needed, or a set maximum.
     * @since 1.0.0
     * @param Worksheet $worksheet The worksheet object.
     * @param int $columns_count The number of columns.
     * @return $this
     */
    protected function autoSizeColumns(Worksheet $worksheet, $columns_count)
    {
        for ($i = 1; $i <= $columns_count; $i++) {
            $worksheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        $max_width = gf_apply_filters([
            'gfexcel_renderer_columns_max_width',
        ], null);

        if (is_int($max_width)) {
            $worksheet->calculateColumnWidths();

            foreach ($worksheet->getColumnDimensions() as $dimension) {
                if ($dimension->getWidth() > $max_width) {
                    $dimension->setAutoSize(false);
                    $dimension->setWidth($max_width);
                }
            }
        }

        return $this;
    }

    /**
     * @param Worksheet $worksheet
     * @param array $matrix
     * @param int $form_id
     * @return $this
     */
    protected function addCellsToWorksheet(Worksheet $worksheet, array $matrix, $form_id)
    {
        foreach ($matrix as $x => $row) {
            $hide_row = (bool) gf_apply_filters([
                'gfexcel_renderer_hide_row',
                $form_id,
            ], false, $row);

            if ($hide_row) {
                $worksheet->getRowDimension($x + 1)->setVisible(false);
            }

            foreach ($row as $i => $value) {
                try {
                    $worksheet->setCellValueExplicitByColumnAndRow(
                        $i + 1,
                        $x + 1,
                        $this->getCellValue($value),
                        $this->getCellType($value)
                    );

                    $cell = $worksheet->getCellByColumnAndRow($i + 1, $x + 1);
                    if (!$cell) {
                        // This isn't going to happen, but it makes the IDE happy.
                        continue;
                    }

                    $this->setProperties($cell, $value, $form_id);

                    $wrap_text = (bool) gf_apply_filters([
                        'gfexcel_renderer_wrap_text',
                        $form_id,
                    ], true, $cell, $value);

                    $worksheet->getStyle($cell->getCoordinate())->getAlignment()->setWrapText($wrap_text);
                } catch (\Exception $e) {
                    $this->handleException($e);
                }
            }
        }

        return $this;
    }

    abstract protected function getFileName();

    /**
     * @param Worksheet $worksheet
     * @param array $form
     * @return $this
     */
    protected function setWorksheetTitle(Worksheet $worksheet, $form)
    {
        $invalidCharacters = Worksheet::getInvalidCharacters();
        // First strip form title, so we still have 30 characters.
        $form_title = str_replace($invalidCharacters, '', $form['title']);
        $worksheet_title = mb_substr(gf_apply_filters([
            'gfexcel_renderer_worksheet_title',
            $form['id'],
        ], $form_title, $form), 0, Worksheet::SHEET_TITLE_MAXIMUM_LENGTH, 'utf-8');

        // Protect users from accidental override with invalid characters.
        $worksheet_title = str_replace($invalidCharacters, '', $worksheet_title);
        $worksheet->setTitle($worksheet_title);

        return $this;
    }

    /**
     * Get Cell type based on value booleans.
     * @param string|BaseValue $value The value of the cell.
     * @return string The type of the cell.
     */
    private function getCellType($value)
    {
        if ($value instanceof BaseValue) {
            if ($value->isNumeric()) {
                return DataType::TYPE_NUMERIC;
            }
            if ($value->isBool()) {
                return DataType::TYPE_BOOL;
            }
        }

        return DataType::TYPE_STRING;
    }

    /**
     * Retrieve the correctly formatted value of the cell
     * @param string|BaseValue $value The value of the cell.
     * @return string The string-value of the cell.
     */
    private function getCellValue($value)
    {
        if ($value instanceof BaseValue) {
            return $value->getValue();
        }

        return $value;
    }

    /**
     * Set url on the cell if value has a url.
     * @param Cell $cell The cell.
     * @param string|BaseValue $value The value of the cell.
     * @return bool Whether the url was set onto the cell.
     */
    private function setCellUrl(Cell $cell, $value)
    {
        if (!$value instanceof BaseValue ||
            !$value->getUrl() ||
            gf_apply_filters(['gfexcel_renderer_disable_hyperlinks'], false)
        ) {
            return false;
        }

        try {
            $cell->getHyperlink()->setUrl($value->getUrl());

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param \Throwable|\Exception $exception
     */
    private function handleException($exception)
    {
        global $wp_version;

        echo '<p><strong>Gravity Forms Entries in Excel: Whoops, unfortunately something is broken.</strong></p>';
        echo '<p><strong>Error message</strong>: ' . nl2br($exception->getMessage()) . ' </p>';
        echo '<p>If you need support for this, please contact me via the';
        echo " <a target='_blank' href='https://wordpress.org/support/plugin/gf-entries-in-excel'>support forum</a> ";
        echo 'on the wordpress plugin.</p>';
        echo '<p>Check if someone else had the same error, before posting a new support question.<br/>';
        echo 'And when opening a new question, <strong>please use the error message ';
        echo 'as the title</strong>, and:</> <p><strong>Include the following details in your message:</strong></p>';
        echo '<ul>';
        echo '<li>Plugin Version: ' . GFExcel::$version . '</li>';
        echo '<li>Gravity Forms Version: ' . GFForms::$version . '</li>';
        echo '<li>PHP Version: ' . PHP_VERSION;
        if (PHP_VERSION_ID < 50601) {
            echo ' (this version is too low, please update to at least PHP 5.6)';
        }
        echo '</li>';
        echo '<li>Wordpress Version: ' . $wp_version . '</li>';
        echo '<li>Error message: ' . nl2br($exception->getMessage()) . '</li>';
        echo '<li>Error stack trace:<br/><br/>' . nl2br($exception->getTraceAsString()) . '</li>';
        echo '</ul>';
        exit;
    }

    /**
     * @param Cell $cell The cell.
     * @param string|BaseValue $value The value of the cell.
     * @param int $form_id The form id.
     * @throws GFExcelException
     */
    private function setProperties(Cell $cell, $value, $form_id)
    {
        $this->setCellUrl($cell, $value);
        $this->setCellStyle($cell, $value);

        gf_do_action(
            [
                'gfexcel_renderer_cell_properties',
                $form_id,
            ],
            $cell,
            $value,
            $form_id
        );
    }

    /**
     * @param Cell $cell The cell.
     * @param string|BaseValue $value The value of the cell.
     * @return bool Whether the font style was applied.
     * @throws GFExcelException
     */
    private function setCellStyle(Cell $cell, $value)
    {
        if (!$value instanceof BaseValue) {
            return false;
        }

        try {
            if ($value->isBold()) {
                $cell->getStyle()->getFont()->setBold(true);
            }

            if ($value->isItalic()) {
                $cell->getStyle()->getFont()->setItalic(true);
            }

            if ($value->hasBorder()) {
                $array = array_filter([
                    $value->getBorderPosition() => array_filter([
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => $value->getBorderColor() ? ['rgb' => $value->getBorderColor()] : null,
                    ]),
                ]);

                $cell->getStyle()->getBorders()->applyFromArray($array);
            }

            if ($color = $value->getColor()) {
                $color_field = $cell->getStyle()->getFont()->getColor();
                $color_field->setRGB($color);
                $cell->getStyle()->getFont()->setColor($color_field);
            }

            if ($color = $value->getBackgroundColor()) {
                $fill = $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID);
                $color_field = $fill->getStartColor()->setRGB($color);
                $fill->setStartColor($color_field);
            }

            if (($font_size = $value->getFontSize())) {
                $font = $cell->getStyle()->getFont();
                $font->setSize($font_size);
            }

            if ($value instanceof NumericValue) {
                $cell->getStyle()->getNumberFormat()->setFormatCode($value->getFormat());
            }

            return true;
        } catch (GFExcelException $e) {
            throw $e;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sets some properties for the CSV Writer.
     * @since 1.7.5
     * @param Csv $objWriter The object writer.
     */
    private function setCsvProperties(Csv $objWriter)
    {
        // updates the delimiter
        $objWriter->setDelimiter((string) apply_filters('gfexcel_renderer_csv_delimiter', $objWriter->getDelimiter()));

        // updates the enclosure
        $objWriter->setEnclosure((string) apply_filters('gfexcel_renderer_csv_enclosure', $objWriter->getEnclosure()));

        // updates the line ending
        $objWriter->setLineEnding((string) apply_filters(
            'gfexcel_renderer_csv_line_ending',
            $objWriter->getLineEnding()
        ));

        // whether to use a BOM
        $objWriter->setUseBOM((bool) apply_filters('gfexcel_renderer_csv_use_bom', $objWriter->getUseBOM()));

        // whether to include a separator line
        $objWriter->setIncludeSeparatorLine((bool) apply_filters(
            'gfexcel_renderer_csv_include_separator_line',
            $objWriter->getIncludeSeparatorLine()
        ));
    }
}
