
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message ADD INDEX `idx_/*TABLE_PREFIX*/t_mmessenger_message_sender_id` (`sender_id`);
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message ADD INDEX `idx_/*TABLE_PREFIX*/t_mmessenger_message_sent_on` (`sentOn`);
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_message ADD INDEX `idx_/*TABLE_PREFIX*/t_mmessenger_message_s_contact_email` (`s_contact_email`);

ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD INDEX `idx_/*TABLE_PREFIX*/t_mmessenger_recipients_recipient_id` (`recipient_id`);
ALTER TABLE /*TABLE_PREFIX*/t_mmessenger_recipients ADD INDEX `idx_/*TABLE_PREFIX*/t_mmessenger_recipients_s_contact_email` (`s_contact_email`);
