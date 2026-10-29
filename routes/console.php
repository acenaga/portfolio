<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('posts:sync')->hourly();
Schedule::command('videos:sync-youtube')->dailyAt('06:00');
Schedule::command('videos:sync-twitch')->dailyAt('06:10');
Schedule::command('instagram:sync')->hourly();
Schedule::command('instagram:refresh-token')->weeklyOn(1, '06:20');
