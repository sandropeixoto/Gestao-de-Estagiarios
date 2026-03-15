<?php
/**
 * TimeSheet Controller - Unified Pattern
 * Orion Orchestrator: Transitioning legacy to App\Models
 */

require_once __DIR__ . '/../../src/Models/TimeSheet.php';

use App\Models\TimeSheet;

class TimeSheetController
{
    private $timesheetModel;

    public function __construct()
    {
        $this->timesheetModel = new TimeSheet();
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON input."]);
            return;
        }

        if ($this->timesheetModel->register($data)) {
            http_response_code(201);
            echo json_encode(["message" => "TimeSheet registered successfully."]);
        }
        else {
            http_response_code(400);
            echo json_encode(["message" => "Unable to register timesheet. Check daily limit (6h standard, 3h test day)."]);
        }
    }
}
