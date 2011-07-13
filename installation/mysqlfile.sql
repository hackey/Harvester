CREATE TABLE `Memory` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(255) NOT NULL,
  `model_Memory` varchar(255) NOT NULL,
  `size_Memory` char(50) NOT NULL,
  `Manufacturer_Memory` varchar(255) NOT NULL,
  `FormFactor_Memory` varchar(255) NOT NULL,
  `MemoryType_Memory` varchar(255) NOT NULL,
  `Speed_Memory` varchar(255) NOT NULL,
  `BankLabel_Memory` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `SoundDevice` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(255) NOT NULL,
  `name_SoundDevice` varchar(255) NOT NULL,
  `Manufacturer_SoundDevice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `Spy` (
  `id` int(11) NOT NULL,
  `Name_User` text NOT NULL,
  `User_comp` text NOT NULL,
  `Date` text NOT NULL,
  `Html_page` text NOT NULL,
  `Comp_record` text NOT NULL,
  `Action` text NOT NULL,
  `f_Table` text NOT NULL,
  `f_Record` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `antivirus_software` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) CHARACTER SET cp1251 DEFAULT NULL,
  `antivirus_name` varchar(100) CHARACTER SET cp1251 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `cd_drives` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `cd_drive_name` varchar(100) DEFAULT NULL,
  `cd_drives_label` char(2) DEFAULT NULL,
  `Manufacturer_cd_drives` varchar(255) NOT NULL,
  `Description_cd_drives` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `computers` (
  `id` int(255) NOT NULL,
  `otdel` text CHARACTER SET utf8 NOT NULL,
  `computer_name` varchar(50) NOT NULL,
  `fio_current_user` varchar(255) DEFAULT NULL,
  `mouse` varchar(255) NOT NULL,
  `keyboard` varchar(255) NOT NULL,
  `Last_Updated` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `ip_addresses` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '',
  `Domen` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `key_user_register` (
  `key_invait` varchar(255) NOT NULL,
  PRIMARY KEY (`key_invait`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `local_users` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_name2` varchar(255) NOT NULL,
  `user_pass2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `mail_accounts` (
  `computer_name` varchar(50) NOT NULL DEFAULT '',
  `mail_client_name` varchar(50) DEFAULT NULL,
  `mail_profile_name` varchar(50) DEFAULT NULL,
  `mail_account_name` text,
  `mail_account_user_name` varchar(100) DEFAULT NULL,
  `mail_account_email` varchar(100) DEFAULT NULL,
  `mail_account_in_srv` varchar(100) DEFAULT NULL,
  `mail_account_in_srv_type` varchar(50) DEFAULT NULL,
  `mail_account_in_srv_auth_type` varchar(50) DEFAULT NULL,
  `mail_account_in_srv_user` varchar(100) DEFAULT NULL,
  `mail_account_out_srv` varchar(100) DEFAULT NULL,
  `mail_account_out_srv_type` varchar(50) DEFAULT NULL,
  `mail_account_out_srv_auth_type` varchar(50) DEFAULT NULL,
  `mail_account_out_srv_user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`computer_name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `monitors` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `monitor_name` varchar(50) DEFAULT NULL,
  `MonitorManufacturer` varchar(255) NOT NULL,
  `ScreenHeight_monitors` int(7) NOT NULL,
  `ScreenWidth_monitors` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `motherboards` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `board_name` varchar(50) DEFAULT NULL,
  `Manufacturer_motherboards` varchar(255) NOT NULL,
  `SerialNumber_motherboards` varchar(255) NOT NULL,
  `Version_motherboards` char(60) NOT NULL,
  `BIOS_name` varchar(255) NOT NULL,
  `Manufacturer_BIOS` varchar(255) NOT NULL,
  `ReleaseDate_BIOS` date NOT NULL,
  `SMBIOSBIOSVersion` varchar(255) NOT NULL,
  `SerialNumber_BIOS` varchar(255) NOT NULL,
  `ComputerSystem_model` varchar(255) NOT NULL,
  `ComputerSystem_Manufacturer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `network_adapters` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `adapter_name` varchar(255) DEFAULT NULL,
  `MACAddress_adapters` varchar(50) NOT NULL,
  `AdapterType` varchar(50) NOT NULL,
  `adapter_linkspeed` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `os` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) NOT NULL,
  `os_name` varchar(50) DEFAULT NULL,
  `os_product_key` varchar(50) DEFAULT NULL,
  `date_install` date NOT NULL,
  `Path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `physical_drives` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) NOT NULL DEFAULT '',
  `model_physical_drives` varchar(255) NOT NULL,
  `InterfaceType_physical_drives` varchar(20) NOT NULL,
  `Manufacturer_physical_drives` varchar(255) NOT NULL,
  `MediaType_physical_drives` varchar(255) NOT NULL,
  `Partitions_physical_drives` int(3) NOT NULL,
  `Size_physical_drives` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `printers` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `printer_name` varchar(50) DEFAULT NULL,
  `PortName_printers` varchar(255) NOT NULL,
  `PrintProcessor` varchar(255) NOT NULL,
  `HorizontalResolution_printers` varchar(30) NOT NULL,
  `VerticalResolution_printers` varchar(30) NOT NULL,
  `type_printers` varchar(255) NOT NULL,
  `date_kartridje_printer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `processors` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `processor_name` varchar(50) DEFAULT NULL,
  `processor_socket_designation` varchar(50) DEFAULT NULL,
  `processor_speed` varchar(50) DEFAULT NULL,
  `MaxClockSpeed_processors` varchar(20) NOT NULL,
  `ExtClock_processors` varchar(100) NOT NULL,
  `Level_processors` varchar(100) NOT NULL,
  `Description_processors` varchar(100) NOT NULL,
  `Manufacturer_processors` varchar(100) NOT NULL,
  `Status_processors` varchar(100) NOT NULL,
  `L2CacheSize_processors` varchar(100) NOT NULL,
  `L2CacheSpeed_processors` varchar(100) NOT NULL,
  `CurrentVoltage_processors` varchar(100) NOT NULL,
  `num_proc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `software` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `software_name1` text,
  `software_name2` text,
  `software_name3` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `user_defined_data` (
  `computer_name` varchar(50) NOT NULL DEFAULT '',
  `category_name` varchar(250) DEFAULT NULL,
  `field_name` varchar(250) DEFAULT NULL,
  `field_value` text,
  PRIMARY KEY (`computer_name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `users_vts_admin` (
  `id` int(11) NOT NULL,
  `name_admin` varchar(20) CHARACTER SET utf8 NOT NULL,
  `_password_admin` varchar(255) NOT NULL,
  `ip` char(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_admin` (`name_admin`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `videoadapters` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL,
  `AdapterCompatibility` varchar(255) NOT NULL,
  `VideoProcessor` varchar(255) NOT NULL,
  `AdapterDACType` varchar(255) NOT NULL,
  `videoadapter_name` varchar(50) DEFAULT NULL,
  `AdapterRAM` varchar(15) NOT NULL,
  `VideoModeDescription` varchar(255) NOT NULL,
  `InstalledDisplayDrivers` varchar(255) NOT NULL,
  `DriverVersion_videoadapters` varchar(255) NOT NULL,
  `MaxRefreshRate_videoadapters` int(4) NOT NULL,
  `MinRefreshRate_videoadapters` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
