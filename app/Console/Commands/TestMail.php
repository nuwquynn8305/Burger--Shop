<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-mail {email : Email address to send the test mail to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify SMTP configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $this->info("Sending test email to {$email}...");
        
        try {
            Mail::raw('This is a test mail from Laravel Burger Shop application.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email from Laravel');
            });
            
            $this->info('Mail sent successfully!');
        } catch (\Exception $e) {
            $this->error('Mail sending failed: ' . $e->getMessage());
        }
    }
}
