<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Base\Project;
use App\Models\Base\Task;
use App\Models\Base\Automate;
use App\Models\User;

class CleanData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all projects, tasks, automates, and their associated directories.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $this->info('Deleting task: ' . $task->title);
            $this->deleteFolder($task->folder);
            $task->delete();
        }

        $automates = Automate::all();
        foreach ($automates as $automate) {
            $this->info('Deleting automate: ' . $automate->name);
            $this->deleteFolder($automate->folder);
            $automate->delete();
        }

        $projects = Project::all();
        foreach ($projects as $project) {
            $this->info('Deleting project: ' . $project->name);
            $this->deleteFolder($project->folder);
            $project->delete();
        }

        $users = User::all();
        foreach ($users as $user) {
            $this->info('Deleting user: ' . $user->name);
            $user->delete();
        }


        $this->info('All data deleted successfully.');
    }

    /**
     * Delete the folder and its contents.
     *
     * @param string $folder
     * @return void
     */
    private function deleteFolder($folder)
    {
        if ($folder) {
            Storage::disk('private')->deleteDirectory($folder);
            Storage::disk('public')->deleteDirectory($folder);
        }
    }
}
