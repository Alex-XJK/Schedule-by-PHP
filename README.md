# Schedule-by-PHP
A multi-time zone personal schedule display and management system written in native PHP.
---
## Disclaimer
This is the webpage code that Alex used to explore the functionality of PHP. The source code was completed in the fall of 2021 and has been actually run on Alex's personal homepage since then.  

However, for ease of understanding and server security reasons, we have made minor changes to the file paths and configuration files associated with it before posting it online.  

We understand that there are a lot of cut-price timetable management software available on the market, and some of them are probably written in PHP too, and we don't deny their excellent performance. However, all the code in this project was written by Alex after he learned it by himself, in order to try to have a deeper understanding of PHP from scratch.   

There may be many hidden bugs or security concerns, so if you are focus on the security and performance of this webpage, please check the code yourself and make the appropriate changes. For general improvements, feel free to submit a Pull Request!

## Project structure
- `Event.php`, `Schedule.php` and `ScheduleRemote.php` are the PHP component code, they follow the object-oriented program development approach and are encapsulated in a individual class.
- `regularSchedule` and `temporarySchedule.php` are the example code in JSON format, they are used to provide data support for the timetable, you can learn the structure and make personalized updates.
- `scheduleInTimezone.php` is the formal entry point to display the timetable, it calls the relevant classes and performs the parameter adjustment.
- `scheduleManagement.php` is the back-end interface for editing the timetable.

## Schedule Diaplay
`scheduleInTimezone.php` can accept some optional parameters in the request URL through GET method:
- `city=ABC` set the timezone to some pre-defined values. In the `Schedule.php#69`, they are set as follows:
```php
$timemap = array (
    "BJS"   =>  8,
    "HKT"   =>  8,
    "UTC"   =>  0,
    "LON"   =>  0,
    "NYC"   =>  -5,
    "CHI"   =>  -6,
    "LAX"   =>  -8
);
```
- `zone=N` set the local timezone from `-12` to `12`. Time zone values and city codes are not supposed to appear at the same time, yet when they do appear at the same time, the time zone values are more deterministic.
- `width=X` where 'X' follows the css style, it set the width of the schedule table.

Example:
The following request URL will display your schedule in Hong Kong Time with table width 85%.
`https://xxx/scheduleInTimezone.php?city=HKT&width=85%`
However, the following code will display your schedule in UTC time, since the `city` parameter is ignored.
`https://xxx/scheduleInTimezone.php?city=HKT&zone=0`

## Schedule Management
`scheduleManagement.php` can receive commands through POST method.  
When the `function` parameter equals to the follow value, it will perform those target behaviors.
| function code | additional parameters needed | function |
| ---- | ----- | ---- |
| change | date, time, [type], [code], [name], [msge], [msgc] | To add / change / override event on the current schedule. The `type` parameter must be one of the existing type in the `Schedule.php` code. For the remaining parameters, check the provided JSON file for reference. |
| setnotice | notice | To set / change the notice line. |
| clsnotice | (null) | Clear the current notice line. |
| roll | (null) | Rollback to a previous recorded state. |



