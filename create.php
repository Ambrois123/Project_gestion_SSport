<?php
try{
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($pdo->exec('DROP DATABASE IF EXISTS db_salle_sport')!== false){
        if ($pdo->exec('CREATE DATABASE db_salle_sport') !== false){
            $db_salle_sport = new PDO('mysql:dbname=db_salle_sport;host=localhost', 'root', '');
            if($db_salle_sport->exec('CREATE TABLE Api_client(
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                client_secret VARCHAR(250),
                client_name VARCHAR(250),
                client_email VARCHAR(250),
                client_address VARCHAR(250),
                active VARCHAR(250),
                short_description TEXT,
                full_description TEXT,
                logo_url VARCHAR(250),
                client_url VARCHAR(250),
                dpo VARCHAR(250),
                technical_contact VARCHAR(250),
                commercial_contact VARCHAR(250)
            )')!==false){
                if($db_salle_sport->exec('CREATE TABLE Api_salle(
                    id INT(11) PRIMARY KEY AUTO_INCREMENT,
                    Api_clientId INT(11),
                    salle_name VARCHAR(250),
                    salle_address VARCHAR(250),
                    FOREIGN KEY (Api_clientId) REFERENCES Api_client(id)
                )') !==false){
                    if($db_salle_sport->exec('CREATE TABLE Api_zone(
                        zone_id INT(11) PRIMARY KEY AUTO_INCREMENT,
                        Api_salleId INT(11),
                        zone_name VARCHAR(250),
                        FOREIGN  KEY (Api_salleId) REFERENCES Api_salle(id)
                    )') !==false){
                        if($db_salle_sport->exec('CREATE TABLE Api_branch(
                            id INT(11) PRIMARY KEY AUTO_INCREMENT,
                            branch_name VARCHAR(250)
                        )') !==false){
                            if($db_salle_sport->exec('CREATE TABLE Api_install_perms(
                                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                                Api_branchId INT(11),
                                members_read INT(11),
                                members_write INT(11),
                                members_add INT(11),
                                members_products_add INT(11),
                                members_payment_schedules_read INT(11),
                                members_statistiques_read INT(11),
                                members_subscription_read INT(11),
                                payment_schedules_read INT(11),
                                payment_schedules_write INT(11),
                                payment_day_read INT(11),
                                FOREIGN KEY (Api_branchId) REFERENCES Api_branch(id)
                            )') !==false){
                                if($db_salle_sport->exec('CREATE TABLE Api_grants(
                                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                                Api_install_permsId INT(11),
                                Api_clientId INT(11),
                                Api_brandId INT(11)
                                perms TEXT,
                                active VARCHAR(250)
                                FOREIGN KEY (Api_install_permsId) REFERENCES Api_install_perms(id),
                                FOREIGN KEY (Api_clientId) REFERENCES Api_client(id),
                                FOREIGN KEY (Api_branchId) REFERENCES Api_branch(id)

                                )') !==false){
                                    echo 'Installation terminée !';
                                }else {
                                    echo 'Impossible de créer Table Api_grants<br>';
                                }
                            }else{
                                echo 'Impossible de créer Table Api_install_perms<br>';
                            }
                        } else {
                            echo 'Impossible de créer Table Api_branch<br>';
                        }
                    }else {
                        echo 'Impossible de créer Table Api_zone<br>';
                    }
                }else{
                    echo 'Impossible de créer Table Api_salle<br>';
                }
            }else {
                echo 'Impossible de créer Table Api_client<br>';
            }
        }
    }
}catch (PDOException $exception){
    die($exception->getMessage());
}
