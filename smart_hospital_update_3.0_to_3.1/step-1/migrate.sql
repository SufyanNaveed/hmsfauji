-- Smart Hospital DB Migration
-- version 3.1
-- https://smart-hospital.in
-- https://qdocs.in
-- New tables added: 2
-- Tables removed: 1


-- --------------------------------------------------------

CREATE TABLE `discharged_summary_opd` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `opd_id` int(11) NOT NULL,
  `operation` varchar(200) NOT NULL,
  `diagnosis` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `investigations` text NOT NULL,
  `treatment_home` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE notification_setting ;

CREATE TABLE `notification_setting` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `is_mail` int(11) DEFAULT '0',
  `is_sms` int(11) DEFAULT '0',
  `is_mobileapp` int(11) NOT NULL,
  `is_notification` int(11) NOT NULL,
  `display_notification` int(11) NOT NULL,
  `display_sms` int(11) NOT NULL,
  `template` longtext NOT NULL,
  `subject` text NOT NULL,
  `variables` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `specialist` (
  `id` int(11) NOT NULL,
  `specialist_name` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `notification_setting` (`id`, `type`, `is_mail`, `is_sms`, `is_mobileapp`, `is_notification`, `display_notification`, `display_sms`, `template`, `subject`, `variables`, `created_at`) VALUES
(1, 'opd_patient_registration', 1, 0, 0, 0, 1, 1, 'Dear {{patient_name}} your OPD Registration is successful at Hospital Name with Patient Id  {{patient_unique_id}} and OPD No  {{opd_no}}', 'OPD Patient', '{{patient_name}} {{mobileno}} {{email}}  {{dob}} {{gender}}  {{patient_unique_id}}    {{opd_no}}', '2020-11-10 06:59:59'),
(2, 'ipd_patient_registration', 1, 0, 0, 0, 1, 1, 'Dear {{patient_name}} your IPD Registration is successful at Hospital Name with Patient Id  {{patient_unique_id}} and IPD No {{ipd_no}}', 'IPD Patient', '{{patient_name}} {{mobileno}} {{email}}  {{dob}} {{gender}}  {{patient_unique_id}}   {{ipd_no}} ', '2020-11-10 06:59:59'),
(3, 'ipd_patient_discharged', 1, 0, 0, 0, 1, 1, 'IPD Patient {{patient_name}} is now discharged from Hospital Name Total Charges: {{currency_symbol}} {{charge_amount}}  Total payment: {{currency_symbol}} {{paid_amount}} Your net payable bill amount was {{currency_symbol}} {{net_amount}}', 'IPD Discharged Patient', '{{patient_name}} {{mobileno}} {{email}} {{dob}} {{gender}} {{patient_unique_id}} {{currency_symbol}} {{charge_amount}} {{paid_amount}} {{net_amount}}', '2020-11-10 06:59:59'),
(4, 'opd_patient_revisit', 1, 0, 0, 0, 1, 1, 'Dear {{patient_name}} your OPD Registration is successful at Hospital Name with Patient Id  {{patient_unique_id}} and OPD No {{opd_no}}\r\n\r\n{{patient_name}} {{mobileno}} {{email}} {{dob}} {{gender}} {{patient_unique_id}} {{opd_no}}', 'OPD Patient Revisit', '{{patient_name}} {{mobileno}} {{email}}  {{dob}} {{gender}}  {{patient_unique_id}} {{opd_no}} ', '2020-11-10 06:59:59'),
(5, 'login_credential', 1, 0, 0, 0, 0, 1, 'Hello {{display_name}} your login details for Url: {{url}} Username:  {{username}} Password: {{password}} {{email}}', 'Login Patient', '{{display_name}}    {{url}} {{username}} {{password}} {{email}}', '2020-11-10 06:57:09'),
(6, 'appointment_approved', 1, 0, 0, 0, 1, 1, 'Dear {{patient_name}} your appointment with {{staff_name}} {{staff_surname}} is confirmed on {{date}} with appointment no: {{appointment_no}}', 'Appointment Approved', '{{patient_name}} {{mobileno}} {{email}}   {{gender}}    {{staff_name}}\r\n{{staff_surname}}  {{date}} {{appointment_no}}', '2020-11-10 06:59:59'),
(7, 'live_meeting', 1, 0, 0, 0, 0, 1, 'Dear staff, your live meeting {{title}} has been scheduled on {{date}} for the duration of {{duration}} minute, please do not share the link to any body.\r\n\r\n{{title}} {{date}} {{duration}} {{employee_id}} {{department}} {{designation}} {{name}} {{contact_no}} {{email}}', 'Live Meeting', '{{title}} {{date}} {{duration}} {{employee_id}} {{department}} {{designation}} {{name}} {{contact_no}} {{email}}', '2020-11-07 12:55:38'),
(8, 'live_consult', 1, 0, 0, 0, 1, 1, 'Dear patient, your live consultation {{title}} has been scheduled on {{date}} for the duration of {{duration}} minute, please do not share the link to any body.\r\n\r\n{{title}} {{date}} {{duration}}', 'Live Consultation', '{{title}} {{date}} {{duration}}', '2020-11-10 06:59:59'),
(9, 'opd_patient_discharged', 1, 0, 0, 0, 1, 1, 'OPD No {{opd_no}}  {{patient_name}} is now discharged from Hospital Name Your net payable bill amount was {{currency_symbol}}  \r\n {{billing_amount}}\r\n\r\n\r\n{{patient_name}} {{mobileno}} {{email}} {{dob}} {{gender}} {{patient_unique_id}} {{opd_no}} {{currency_symbol}} {{billing_amount}}', 'OPD Discharged Patient', '{{patient_name}} {{mobileno}} {{email}} {{dob}} {{gender}} {{patient_unique_id}} {{opd_no}}{{currency_symbol}} {{billing_amount}}', '2020-11-10 06:59:59'),
(10, 'forgot_password', 1, 0, 0, 0, 0, 0, 'Dear  {{display_name}} , Recently a request was submitted to reset password for your account. If you didn\'t make the request, just ignore this email. Otherwise you can reset your password using this link <a href=\'{{resetpasslink}}\'>Click here to reset your password</a>, if you\'re having trouble clicking the password reset button, copy and paste the URL below into your web browser. {{resetpasslink}} <br> Regards,  <br>\r\n{{site_url}}', 'Password Update Request', '{{display_name}}  {{email}}  {{resetpasslink} {{site_url}}', '2020-11-07 12:54:53');

INSERT INTO `permission_category` (`id`, `perm_group_id`, `name`, `short_code`, `enable_view`, `enable_add`, `enable_edit`, `enable_delete`, `created_at`) 
VALUES (NULL, '18', 'Specialist', 'specialist', '1', '1', '1', '1', '2019-10-04 02:31:33');

INSERT INTO `permission_category` (`id`, `perm_group_id`, `name`, `short_code`, `enable_view`, `enable_add`, `enable_edit`, `enable_delete`, `created_at`) VALUES (NULL, '22', 'General Income Widget', 'general_income_widget', '1', '0', '0', '0', '2018-12-20 09:08:05');

INSERT INTO `permission_category` (`id`, `perm_group_id`, `name`, `short_code`, `enable_view`, `enable_add`, `enable_edit`, `enable_delete`, `created_at`) VALUES (NULL, '22', 'Expenses Widget', 'expenses_widget', '1', '0', '0', '0', '2018-12-20 09:08:05');

UPDATE `permission_group` SET `name` = 'Zoom Live Consultation' WHERE `permission_group`.`id` = 37;

UPDATE `languages` SET `language` = 'Haitian' WHERE `languages`.`id` = 17;

INSERT INTO `payment_settings` (`id`, `payment_type`, `api_username`, `api_secret_key`, `salt`, `api_publishable_key`, `paytm_website`, `paytm_industrytype`, `api_password`, `api_signature`, `api_email`, `paypal_demo`, `account_no`, `is_active`, `created_at`) VALUES
(NULL, 'pesapal', NULL, '', '', '', '', '', NULL, NULL, NULL, '', '', 'no', '2020-11-05 04:50:40'),
(NULL, 'ipayafrica', NULL, '', '', '', '', '', NULL, NULL, NULL, '', '', 'no', '2020-11-05 04:50:40');

ALTER TABLE ambulance_call
    ADD COLUMN `call_from` varchar(200) NOT NULL AFTER `generated_by`,
    ADD COLUMN `call_to` varchar(200) NOT NULL AFTER `call_from`;
	  
ALTER TABLE appointment
    ADD COLUMN `specialist` varchar(100) NOT NULL AFTER `mobileno`;

ALTER TABLE messages
    ADD COLUMN `file` varchar(200) NOT NULL AFTER `is_individual`;
	
ALTER TABLE send_notification
    ADD COLUMN `visible_patient` varchar(12) NOT NULL AFTER `visible_staff`;	

ALTER TABLE send_notification
  	DROP COLUMN visible_student;
	
ALTER TABLE send_notification
  	DROP COLUMN visible_parent;

ALTER TABLE messages
  	DROP COLUMN is_class;

ALTER TABLE staff
    ADD COLUMN `specialist` varchar(200) NOT NULL AFTER `designation`;

ALTER TABLE visit_details
    ADD COLUMN `discharged` varchar(200) NOT NULL AFTER `generated_by`;

ALTER TABLE `discharged_summary_opd`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notification_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `specialist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `discharged_summary_opd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `notification_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `specialist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

