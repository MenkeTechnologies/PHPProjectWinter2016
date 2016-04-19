/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  jacobmenke
 * Created: Feb 20, 2016
 */

CREATE TABLE `games` (
`gameID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`title` VARCHAR(50) NOT NULL,
`subtitle` VARCHAR(100) NULL,
`minPlayers` TINYINT(3) NOT NULL,
`maxPlayers` TINYINT(3) NULL,
`releaseDate` DATE NOT NULL,
`type` ENUM('board','video','card','table','other') NOT NULL DEFAULT 'board',
`publisher` INT(11) UNSIGNED NULL,
`description` TEXT NULL,
`ageRating`ENUM('kid','adult','all_ages') NOT NULL DEFAULT 'all_ages'
) ENGINE=MyIsam;

(69.0 * (sqrt((l.longitude-(-83.7113))^2 + (l.latitude-42.3241) ^2)))

set @distance = (69.0 *
sqrt(pow((l.longitude-(-83.7113)),2) + pow((l.latitude-42.3241),2)));

select l.state, l.location_name,
l.zipcode, l.longitude, l.latitude, @distance, p.provider_number, p.person_name,
group_concat(t.subject_label) from a5_locations as l


join a5_people as p on p.locationID = l.locationID
join a5_people_subject as s on s.personID = p.personID
join a5_subject as t on t.subjectID = s.subjectID
group by p.personID where @distance < 25.0;