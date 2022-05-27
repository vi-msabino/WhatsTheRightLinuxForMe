create or replace table WhatstherightLinuxforme.Linux (
	l_name varchar(50) NOT NULL,
    l_erfahrungsgrad int,
    l_konfigurierbarkeit int,
    l_secure_boot boolean,
    l_packetmanager varchar(50),
    l_quelloffen boolean,
    PRIMARY KEY (l_name)
);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('Ubuntu', 0, 0, 0, false, true);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('Debian', 1, 1, 0, true, true);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('Arch Linux', 1, 2, 2, false, false);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('MX Linux', 1, 1, 0, true, false);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('openSUSE Tumbleweed', 1, 1, 1, true, true);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('Fedora', 0, 0, 1, true, true);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('Linux Mint', 0, 0, 0, false, true);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('elementary OS', 0, 0, 0, false, true);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('Manjaro', 0, 0, 2, false, false);
insert into WhatstherightLinuxforme.Linux (l_name, l_konfigurierbarkeit, l_erfahrungsgrad, l_packetmanager, l_quelloffen, l_secure_boot)
values ('DeepIn', 0, 0, 0, true, true);

create or replace table WhatstherightLinuxforme.Desktop(
    d_name varchar(100) NOT NULL,
    d_windows_look boolean,
    d_pfad_bild varchar(100),
    PRIMARY KEY (d_name)
);
insert into WhatstherightLinuxforme.Desktop values ('KDE Plasma', true, 'kde.png');
insert into WhatstherightLinuxforme.Desktop values ('Gnome', false, 'gnome.png');
insert into WhatstherightLinuxforme.Desktop values ('Cinnamon', true, 'cinnamon.png');
insert into WhatstherightLinuxforme.Desktop values ('Xfce', false, 'xfce.png');
insert into WhatstherightLinuxforme.Desktop values ('MATE', true, 'mate.png');
insert into WhatstherightLinuxforme.Desktop values ('LxQt', true, 'lxqt.png');
insert into WhatstherightLinuxforme.Desktop values ('Pantheon', false, 'pantheon.png');

create or replace table WhatstherightLinuxforme.HW_Anforderungen(
    hw_id int not null,
    hw_value varchar(50),
    primary key(hw_id)
);

insert into WhatstherightLinuxforme.HW_Anforderungen (hw_id, hw_value) values (0, 'Uralt PCs (32 bit)');
insert into WhatstherightLinuxforme.HW_Anforderungen (hw_id, hw_value) values (1, 'Schwache Hardware');
insert into WhatstherightLinuxforme.HW_Anforderungen (hw_id, hw_value) values (2, 'Brandaktuelle Hardware');

create or replace table WhatstherightLinuxforme.Aktualitaet(
    ak_id int not null ,
    ak_value varchar(100),
    primary key(ak_id)
);

insert into WhatstherightLinuxforme.Aktualitaet (ak_id, ak_value) values (0, 'Rolling Release');
insert into WhatstherightLinuxforme.Aktualitaet (ak_id, ak_value) values (1, 'Jährliche Updates');
insert into WhatstherightLinuxforme.Aktualitaet (ak_id, ak_value) values (2, 'long time support');

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
    PRIMARY KEY (n_id),
    foreign key(n_hw_anforderungen) REFERENCES WhatstherightLinuxforme.HW_Anforderungen(hw_id),
    foreign key(n_aktualisierungen) REFERENCES WhatstherightLinuxforme.Aktualitaet(ak_id)
);
create or replace table WhatstherightLinuxforme.Nutzer_Desktop(
    nd_id int not null AUTO_INCREMENT,
	n_id int NOT NULL,
    d_name varchar(100) NOT NULL,
    foreign key(n_id) REFERENCES WhatstherightLinuxforme.Nutzer(n_id),
    foreign key(d_name) REFERENCES WhatstherightLinuxforme.Desktop(d_name),
    PRIMARY KEY (nd_id)
);
create or replace table WhatstherightLinuxforme.Linux_Desktop(
    nd_id int not null auto_increment,
    l_name varchar(50) NOT NULL,
    d_name varchar(100) NOT NULL,
    foreign key(l_name) REFERENCES WhatstherightLinuxforme.Linux(l_name),
    foreign key(d_name) REFERENCES WhatstherightLinuxforme.Desktop(d_name),
    PRIMARY KEY (nd_id)
);
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Ubuntu', 'Gnome'); 
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Debian', 'Gnome');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Debian', 'KDE Plasma');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Debian', 'Xfce');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Debian', 'Cinnamon');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Debian', 'MATE');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Debian', 'LxQt');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'Gnome');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'KDE Plasma');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'Xfce');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'Cinnamon');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'MATE');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'LxQt');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Arch Linux', 'Pantheon');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('MX Linux', 'KDE Plasma');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('MX Linux', 'Xfce');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('openSUSE Tumbleweed', 'Gnome');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('openSUSE Tumbleweed', 'KDE Plasma');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('openSUSE Tumbleweed', 'Xfce');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Fedora', 'Gnome');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Linux Mint', 'Xfce');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Linux Mint', 'Cinnamon');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Linux Mint', 'MATE');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('elementary OS', 'Pantheon');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Manjaro', 'Gnome');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Manjaro', 'KDE Plasma');
insert into WhatstherightLinuxforme.Linux_Desktop (l_name, d_name) values ('Manjaro', 'Xfce');

create or replace table WhatstherightLinuxforme.Nutzer_Linux(
    nl_id int not null auto_increment,
	n_id int NOT NULL,
    l_name varchar(50) NOT NULL,
    nl_ranking int,
    foreign key(n_id) REFERENCES WhatstherightLinuxforme.Nutzer(n_id),
    foreign key(l_name) REFERENCES WhatstherightLinuxforme.Linux(l_name),
    PRIMARY KEY (nl_id)
);

create or replace table WhatstherightLinuxforme.Linux_HW_Anforderungen(
    nh_id int not null auto_increment,
	l_name varchar(50) NOT NULL,
    hw_id int NOT NULL,
    foreign key(l_name) REFERENCES WhatstherightLinuxforme.Linux(l_name),
    foreign key(hw_id) REFERENCES WhatstherightLinuxforme.HW_Anforderungen(hw_id),
    PRIMARY KEY (nh_id)
);

insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('openSUSE Tumbleweed', 0);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Debian', 0);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Debian', 1);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('openSUSE Tumbleweed', 1);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Linux Mint', 1);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Arch Linux', 1);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('MX Linux', 1);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('openSUSE Tumbleweed', 2);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Arch Linux', 2);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Fedora', 2);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Manjaro', 2);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('elementary OS', 2);
insert into WhatstherightLinuxforme.Linux_HW_Anforderungen (l_name, hw_id) values ('Ubuntu', 2);

create or replace table WhatstherightLinuxforme.Linux_Aktualitaet(
    na_id int not null auto_increment,
	l_name varchar(50) NOT NULL,
    ak_id int NOT NULL,
    foreign key(l_name) REFERENCES WhatstherightLinuxforme.Linux(l_name),
    foreign key(ak_id) REFERENCES WhatstherightLinuxforme.Aktualitaet(ak_id),
    PRIMARY KEY (na_id)
);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Arch Linux', 0);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Manjaro', 0);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('openSUSE Tumbleweed', 0);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Fedora', 1);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('MX Linux', 1);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Ubuntu', 1);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('elementary OS', 1);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Linux Mint', 1);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Debian', 2);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('Linux Mint', 2);
insert into WhatstherightLinuxforme.Linux_Aktualitaet (l_name, ak_id) values ('elementary OS', 2);
