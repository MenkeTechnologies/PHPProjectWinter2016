/* 
 * created by Jacob Menke
 * 
 */
/**
 * Author:  jacobmenke
 * Created: Apr 18, 2016

 */

create table `tutorials` (
`id` int(11) unsigned not null auto_increment primary key,
`title` varchar(32) not null,
`author` varchar(32) not null,
`published_date` date not null,
`description` text null,
`price` decimal (9,2) unsigned,
`category` enum('Programming','CAD','Networking','OS','Productivity') not null default 'Programming',
`length` smallint(2) unsigned not null
)