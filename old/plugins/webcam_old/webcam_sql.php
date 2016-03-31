CREATE TABLE webcams (
  webcam_id int(10) unsigned not null AUTO_INCREMENT,
  webcam_name varchar(50) not null default '',
  webcam_refresh int(10) unsigned not null default '0',
  webcam_approved int(10) unsigned not null default '0',
  webcam_url text NOT NULL,
  webcam_description text NOT NULL,
  webcam_poster varchar(100) not null default '0.anon',
  webcam_provider varchar(100) not null default '',
  webcam_providerurl varchar(100) not null default '',
  webcam_location varchar(100) not null default '',
  webcam_updated int(10) unsigned not null default '0',
  webcam_order int(10) unsigned not null default '1',
  webcam_views int(10) unsigned not null default '0',
  webcam_menu int(10) unsigned not null default '0',
    PRIMARY KEY  (webcam_id)
  ) TYPE=MyISAM;