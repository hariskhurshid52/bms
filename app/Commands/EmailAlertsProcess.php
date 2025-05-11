<?php

namespace App\Commands;

use App\Libraries\EmailProcess;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class EmailAlertsProcess extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Tasks';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'task:process';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write('Starting backend process...', 'green');

        $service = new EmailProcess();
        try {
            $service->ScheduledSubmissionDateEmailReminder();
        } catch (\Exception $e) {
        }
        try{
            $service->ScheduledDeliveryDateEmailReminder();
        } catch (\Exception $e) {
        }
        try {
            $service->ScheduledSubmissionNotificationReminder();
        }catch (\Exception $e) {

        }
        try {
            $service->ScheduledDeliveryNotificationReminder();
        }catch (\Exception $e) {

        }

    }
}
