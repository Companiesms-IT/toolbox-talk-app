<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ToolboxTalk;
use App\Models\AttemptQuestion;
use App\Models\Question;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Works;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ToolboxTalkCSVExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */


    protected $toolboxTalkCSV;

    public function __construct(ToolboxTalk $toolboxTalkCSV)
    {
        $this->toolboxTalkCSV = $toolboxTalkCSV;
    }

    public function collection()
    {
        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();

        // // Set title and merge cells (A1:F1)
        // $sheet->setCellValue('A1', 'Toolbox Talk Title: ' . $this->toolboxTalkCSV->title);
        // $sheet->mergeCells('A1:F1');
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // // Set column headers
        // $sheet->setCellValue('A2', 'Name');
        // $sheet->setCellValue('B2', 'Date');
        // $sheet->setCellValue('C2', 'Time');
        // $sheet->setCellValue('D2', 'Result');
        // $sheet->setCellValue('E2', 'Attempts');
        // $sheet->setCellValue('F2', 'Completed');

        // // Add data rows
        // $row = 3;
        // foreach ($this->toolboxTalkCSV->getAssignedUsers as $assignedUser) {
        //     $dateTime = $assignedUser->date_time;
        //     $time = $dateTime ? date('H:i:s', strtotime($dateTime)) : null;
        //     $date = $dateTime ? date('m/d/Y', strtotime($dateTime)) : null;

        //     $userId = $assignedUser->user_id;
        //     $toolboxId = $this->toolboxTalkCSV->id;
        //     $lastAttempt = $assignedUser->attempt_count;

        //     $correctAnswersCount = AttemptQuestion::where('user_id', $userId)
        //         ->where('toolbox_talk_id', $toolboxId)
        //         ->where('is_correct', '1')
        //         ->where('attempt_count', $lastAttempt)
        //         ->count();

        //     $totalQuestionsCount = AttemptQuestion::where('user_id', $userId)
        //         ->where('toolbox_talk_id', $toolboxId)
        //         ->where('attempt_count', $lastAttempt)
        //         ->count();

        //     $resultData = $totalQuestionsCount > 0 ? "{$correctAnswersCount}/{$totalQuestionsCount}" : "0/0";

        //     if ($assignedUser->status == "2") {
        //         $status = "Completed";
        //     } else if ($assignedUser->status == "3") {
        //         $status = "Ongoing";
        //     } else {
        //         $status = "Ended";
        //     }

        //     $sheet->setCellValue('A' . $row, $assignedUser->user_name ?? "N/A");
        //     $sheet->setCellValue('B' . $row, $date ?? "N/A");
        //     $sheet->setCellValue('C' . $row, $time ?? "N/A");
        //     $sheet->setCellValue('D' . $row, $resultData ?? "N/A");
        //     $sheet->setCellValue('E' . $row, ($assignedUser->attempt_count != null || $assignedUser->attempt_count != '') ? $assignedUser->attempt_count : "N/A");
        //     $sheet->setCellValue('F' . $row, $status ?? "N/A");

        //     $row++;
        // }

        // // Set headers for download
        // $filename = 'toolbox_talk_export.csv';
        // header('Content-Type: text/csv');
        // header('Content-Disposition: attachment; filename="' . $filename . '"');
        // header('Pragma: no-cache');
        // header('Expires: 0');

        // // Output CSV
        // $writer = new Csv($spreadsheet);
        // $writer->save('php://output');
        // exit();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title and merge cells (A1:F1)
        $sheet->setCellValue('A1', 'Toolbox Talk Title: ' . $this->toolboxTalkCSV->title);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Make title bold
        $sheet->getStyle('A1')->getFont()->setBold(true);

        // Set column headers
        $headers = ['Name', 'Date', 'Time', 'Result', 'Attempts', 'Completed'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '2', $header);
            // Make header bold
            $sheet->getStyle($col . '2')->getFont()->setBold(true);
            $col++;
        }

        // Add data rows (your existing code here)
        $row = 3;
        foreach ($this->toolboxTalkCSV->getAssignedUsers as $assignedUser) {
            $dateTime = $assignedUser->date_time;
            $time = $dateTime ? date('H:i:s', strtotime($dateTime)) : null;
            $date = $dateTime ? date('d/m/Y', strtotime($dateTime)) : null;
            $userId = $assignedUser->user_id;
            $toolboxId = $this->toolboxTalkCSV->id;
            $lastAttempt = $assignedUser->attempt_count;
            $correctAnswersCount = AttemptQuestion::where('user_id', $userId)
                ->where('toolbox_talk_id', $toolboxId)
                ->where('is_correct', '1')
                ->where('attempt_count', $lastAttempt)
                ->count();
            $totalQuestionsCount = AttemptQuestion::where('user_id', $userId)
                ->where('toolbox_talk_id', $toolboxId)
                ->where('attempt_count', $lastAttempt)
                ->count();
            $resultData = $totalQuestionsCount > 0 ? "{$correctAnswersCount}/{$totalQuestionsCount}" : "0/0";
            if ($assignedUser->status == "2") {
                $status = "Completed";
            } else if ($assignedUser->status == "3") {
                $status = "Ongoing";
            } else {
                $status = "Ended";
            }
            $sheet->setCellValue('A' . $row, $assignedUser->user_name ?? "N/A");
            $sheet->setCellValue('B' . $row, $date ?? "N/A");
            $sheet->setCellValue('C' . $row, $time ?? "N/A");
            $sheet->setCellValue('D' . $row, $resultData ?? "N/A");
            $sheet->setCellValue('E' . $row, ($assignedUser->attempt_count != null || $assignedUser->attempt_count != '') ? $assignedUser->attempt_count : "N/A");
            $sheet->setCellValue('F' . $row, $status ?? "N/A");
            $row++;
        }
        // Set headers for download
        $filename = 'toolbox_talk_export.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output Excel file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // public function headings(): array
    // {
    //     return [
    //         'ID',
    //         'Name',
    //         'Email',
    //         'Created At',
    //     ];
    // }

    // /**
    //  * Apply styles to the worksheet
    //  */
    // public function styles(Worksheet $sheet)
    // {
    //     // Make first row (header) bold
    //     return [
    //         1 => ['font' => ['bold' => true]],
    //     ];
    // }




}
