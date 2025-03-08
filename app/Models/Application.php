<?php

namespace App\Models;

class Application
{
    public int $id;
    public int $user_id;
    public string $application_id;
    public string $program_applied;
    public string $term_year;
    public string $admission_decision;
    public string $reason_for_appeal;
    public string $created_at;
}