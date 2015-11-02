-----------------
-- USERS TABLE --
-----------------
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `users` ADD PRIMARY KEY (`userid`);

ALTER TABLE `users`  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;

--------------------
-- SESSIONS TABLE --
--------------------

CREATE TABLE IF NOT EXISTS `sessions` (
  `sessionid` varchar(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `loginat` datetime NOT NULL,
  `validuntil` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


