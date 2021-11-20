# Host: localhost  (Version 5.5.5-10.4.14-MariaDB)
# Date: 2021-10-30 11:02:35
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Data for table "failed_jobs"
#


#
# Data for table "migrations"
#

REPLACE INTO `migrations` (`id`,`migration`,`batch`) VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_09_01_233534_create_contas_table',1),(6,'2021_09_02_000001_create_categorias_table',1),(7,'2021_09_02_002057_create_receitas_table',1),(8,'2021_09_02_002105_create_despesas_table',1),(9,'2021_10_30_133713_create_objetivos_table',1);

#
# Data for table "objetivos"
#


#
# Data for table "password_resets"
#


#
# Data for table "personal_access_tokens"
#


#
# Data for table "users"
#

REPLACE INTO `users` (`id`,`nome`,`email`,`data_nascimento`,`sexo`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'David','davidmdchagas@hotmail.com','1996-09-21','Masc',NULL,'$2y$10$KkNmOKrc3Uz2bTfIi8Q6feHgRhabTBm/uHhkTYhw0Q/BYTDSQUeOu',NULL,'2021-10-30 13:55:10','2021-10-30 13:55:10');

#
# Data for table "contas"
#

REPLACE INTO `contas` (`id`,`descricao`,`valor`,`usuario_id`) VALUES (1,'Carteira',604000,1),(2,'Nuconta',50000,1);

#
# Data for table "categorias"
#

REPLACE INTO `categorias` (`id`,`descricao`,`tipo`,`usuario_id`) VALUES (1,'Salário','Receita',1),(2,'Bonus','Receita',1),(3,'Transporte','Despesa',1),(4,'Alimentação','Despesa',1),(5,'Lazer','Despesa',1),(6,'Educação','Despesa',1);

#
# Data for table "receitas"
#

REPLACE INTO `receitas` (`id`,`valor`,`status`,`data`,`descricao`,`receita_fixa`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1300000,'pago','2021-09-05','Pagamento','sim','teste',1,1,1),(250000,'pago','2021-09-05','Bonus produtividade','nao','teste',1,1,2),(3300000,'pago','2021-10-05','Pagamento','sim','teste',1,1,1),(465000,'pago','2021-10-05','Bonus produtividade','nao','teste',1,1,2);

#
# Data for table "despesas"
#

REPLACE INTO `despesas` (`id`,`valor`,`status`,`data`,`descricao`,`despesa_fixa`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (120000,'pago','2021-09-08','Onibus Faculdade','nao','teste',1,1,3),(25000,'pago','2021-09-15','Uber','nao','teste',1,1,3),(380000,'pago','2021-09-05','Faculdade','sim','teste',1,1,6),(480000,'pago','2021-10-05','Faculdade','sim','teste',1,1,6),(526000,'pago','2021-10-10','Onibus Faculdade','nao','teste',1,1,3);
