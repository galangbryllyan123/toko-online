CREATE TABLE IF NOT EXISTS `/*TABLE_PREFIX*/t_usl_soc_networks` (
  `usl_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `usl_name` varchar(255) NOT NULL,
  `usl_code` varchar(10) NOT NULL,
  `usl_ph_id` varchar(255) NOT NULL,
  `usl_ph_secret` varchar(255) NOT NULL,
  `usl_position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`usl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `/*TABLE_PREFIX*/t_usl_soc_networks` (`usl_id`, `usl_name`, `usl_code`, `usl_ph_id`, `usl_ph_secret`, `usl_position`) VALUES
(1, 'Facebook', 'fb', 'Facebook App ID', 'Facebook App Secret', 1),
(2, 'Google+', 'gg', 'Google Client ID', 'Google Client Secret', 2),
(3, 'Twitter', 'tw', 'Twitter API Key', 'Twitter API Secret', 3),
(4, 'Instagram', 'inst', 'Instagram Client ID', 'Instagram Client Secret', 4),
(5, 'LinkedIn', 'lin', 'LinkedIn Client ID', 'LinkedIn Client Secret', 5),
(6, 'Windows Live', 'win', 'Windows Live ID', 'Windows Live Password', 6),
(7, 'Yahoo', 'yh', 'Yahoo Client ID', 'Yahoo Client Secret', 7),
(8, 'Odnoklassniki', 'ok', 'Odnoklassniki Application ID', 'Odnoklassniki Secret Key', 8),
(9, 'Vkontakte', 'vk', 'Vkontakte Client ID', 'Vkontakte Secret Key', 9),
(10, 'Mail.ru', 'ml', 'Mail.ru Client ID', 'Mail.ru Secret Key', 10),
(11, 'Yandex', 'yx', 'Yandex ID', 'Yandex Password', 11);