create or replace table WhatstherightLinuxforme.Linux (
	l_name varchar(50) NOT NULL,
    l_hw_anforderungen int,
    l_erfahrungsgrad int,
    l_konfigurierbarkeit int,
    l_aktualisierungen int,
    l_secure_boot boolean,
    l_packetmanager varchar(50),
    l_quelloffen boolean,
    PRIMARY KEY (l_name)
);
create or replace table WhatstherightLinuxforme.Desktop(
    d_name varchar(100) NOT NULL,
    d_windows_look boolean,
    d_pfad_bild varchar(100),
    PRIMARY KEY (des_name)
);
insert into WhatstherightLinuxforme.Desktop values ('KDE Plasma', true, 'kde.png');
insert into WhatstherightLinuxforme.Desktop values ('Gnome', false, 'gnome.png');
insert into WhatstherightLinuxforme.Desktop values ('Cinnamon', true, 'cinnamon.png');
insert into WhatstherightLinuxforme.Desktop values ('Xfce', false, 'xfce.png');
insert into WhatstherightLinuxforme.Desktop values ('MATE', true, 'mate.png');
insert into WhatstherightLinuxforme.Desktop values ('LxQt', true, 'lxqt.png');
insert into WhatstherightLinuxforme.Desktop values ('Pantheon', false, 'pantheon.png');

create or replace table WhatstherightLinuxforme.Nutzer (
    n_id int NOT NULL AUTO_INCREMENT,
    n_name varchar(200),
    n_hw_anforderungen int,
    n_erfahrungsgrad int,
    n_konfigurierbarkeit int,
    n_aktualisierungen int,
    n_secure_boot boolean,
    n_packetmanager varchar(50),
    n_quelloffen boolean,
    PRIMARY KEY (n_id)
);
create or replace table WhatstherightLinuxforme.Nutzer_Desktop(
	n_id int NOT NULL,
    d_name varchar(100) NOT NULL,
    PRIMARY KEY (n_id, d_name)
);
create or replace table WhatstherightLinuxforme.Linux_Desktop(
	l_name varchar(50) NOT NULL,
    d_name varchar(100) NOT NULL,
    PRIMARY KEY (l_name, d_name)
);
create or replace table WhatstherightLinuxforme.Nutzer_Linux(
	n_id int NOT NULL,
    l_name varchar(50) NOT NULL,
    nl_ranking int,
    PRIMARY KEY (n_id, l_name)
);
create or replace table WhatstherightLinuxforme.Fragestellung(
	f_id int NOT NULL AUTO_INCREMENT,
    Frage varchar(500),
    PRIMARY KEY (f_id)
);
