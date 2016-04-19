/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  jacobmenke
 * Created: Mar 5, 2016
 */

# query to get spies in Berlin

select l.*, s.name
from spy_locations l
left join spy s on s.locationID=l.locationID
where l.locationID=3;

# spies on side A and their cities

select s.name, s.side, l.name
from spy s
join spy_locations l on l.locationID=s.locationID
where s.side='A';

# disguises of spy#3

select s.name, d.label
from spy s
left join spy_disguises sd
on sd.spyID = s.spyID
left join disguises d
on d.disguiseID = sd.disguiseID
where s.spyID = 3;

# disguises of all spies

select s.name, d.label
from spy s
left join spy_disguises sd
on sd.spyID = s.spyID
left join disguises d
on d.disguiseID = sd.disguiseID
group by s.spyID;

# diguises of all spies

select s.name, GROUP_CONCAT(d.label) as disguises
from spy s
left join spy_disguises sd
on sd.spyID = s.spyID
left join disguises d
on d.disguiseID = sd.disguiseID
group by s.spyID;

# count

select s.name, Count(d.label) as disguises
from spy s
left join spy_disguises sd
on sd.spyID = s.spyID
left join disguises d
on d.disguiseID = sd.disguiseID
group by s.spyID;

select
from
join
where
group by
where
order by
limit

# insert a location
INSERT into spy_locations
set name =AES_ENCRYPT('Paris','password1');


# extracting encrpyted data
select AES_DECRYPT(name,'password1') from spy_locations where locationID=6;