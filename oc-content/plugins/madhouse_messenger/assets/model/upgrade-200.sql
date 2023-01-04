CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_mmessenger_resource (
    `pk_i_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `fk_i_message_id` INT(10) UNSIGNED NULL,
    `s_secret` VARCHAR(255) NULL,
    `s_name` VARCHAR(255) NULL,
    `s_extension` VARCHAR(10) NULL,
    `s_content_type` VARCHAR(40) NULL,
    `s_path` VARCHAR(255) NULL,
    `s_original_name` VARCHAR(245) NULL,
    PRIMARY KEY (`pk_i_id`),
    CONSTRAINT `fk_/*TABLE_PREFIX*/t_mmessenger_message_resource`
        FOREIGN KEY(`fk_i_message_id`)
        REFERENCES /*TABLE_PREFIX*/t_mmessenger_message(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_events
    ADD `b_system` BOOLEAN NOT NULL DEFAULT 0;

UPDATE /*TABLE_PREFIX*/t_mmessenger_events SET
    `b_system` = '1'
WHERE `name` IN ('item_deleted', 'item_spammed');

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message ADD `s_secret` varchar(30) NULL AFTER `id`;
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message ADD `s_contact_name` VARCHAR(255) NULL AFTER `sender_id`;
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message ADD `s_contact_email` VARCHAR(255) NULL AFTER `s_contact_name`;

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message MODIFY `sender_id` INT(10) UNSIGNED NULL;

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD `pk_i_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE FIRST;
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD `s_contact_name` VARCHAR(255) NULL AFTER `recipient_id`;
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD `s_contact_email` VARCHAR(255) NULL AFTER `s_contact_name`;

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients DROP FOREIGN KEY `fk_/*TABLE_PREFIX*/t_mmessenger_recipients_message`;
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients DROP PRIMARY KEY;
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD PRIMARY KEY (`pk_i_id`);
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD CONSTRAINT `fk_/*TABLE_PREFIX*/t_mmessenger_recipients_message`
    FOREIGN KEY(`message_id`)
    REFERENCES /*TABLE_PREFIX*/t_mmessenger_message(`id`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD CONSTRAINT UNIQUE (`message_id`, `recipient_id`);
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD CONSTRAINT UNIQUE (`message_id`, `s_contact_email`);

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients MODIFY `recipient_id` INT(10) UNSIGNED NULL;
