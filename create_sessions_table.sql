-- Create sessions table for CodeIgniter database session driver
CREATE TABLE `ci_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
);

-- Alternative if you prefer to use session_id as primary key
-- ALTER TABLE `ci_sessions` ADD PRIMARY KEY (`id`, `ip_address`);
-- ALTER TABLE `ci_sessions` ADD KEY `ci_sessions_timestamp` (`timestamp`);
