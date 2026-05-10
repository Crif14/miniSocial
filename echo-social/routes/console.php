<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('comments:clean')->daily();