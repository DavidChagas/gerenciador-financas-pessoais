# Host: localhost  (Version 5.5.5-10.4.14-MariaDB)
# Date: 2021-11-28 22:26:49
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Data for table "failed_jobs"
#


#
# Data for table "migrations"
#

REPLACE INTO `migrations` (`id`,`migration`,`batch`) VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_09_01_233534_create_contas_table',1),(6,'2021_09_02_000001_create_categorias_table',1),(7,'2021_09_02_002057_create_receitas_table',1),(8,'2021_09_02_002105_create_despesas_table',1),(9,'2021_10_30_133713_create_objetivos_table',1),(10,'2021_11_02_232832_create_objetivo_aportes_table',1);

#
# Data for table "password_resets"
#


#
# Data for table "personal_access_tokens"
#


#
# Data for table "users"
#

REPLACE INTO `users` (`id`,`nome`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'David Chagas','davidmdchagas@hotmail.com',NULL,'$2y$10$85jeklibHFqvTsY.aRIOl.lzmaEazhOv1y4tL.N.oBJRo9VDOKvuq',NULL,'2021-11-29 01:13:27','2021-11-29 01:13:27');

#
# Data for table "objetivos"
#

REPLACE INTO `objetivos` (`id`,`nome`,`descricao`,`valor`,`data_inicial`,`data_final`,`usuario_id`) VALUES (1,'Comprar um celular novo',NULL,400000,'2021-10-05','2022-06-01',1);

#
# Data for table "objetivo_aportes"
#

REPLACE INTO `objetivo_aportes` (`id`,`valor`,`data`,`objetivo_id`) VALUES (1,20000,'2021-10-05',1),(2,40000,'2021-11-05',1);

#
# Data for table "contas"
#

REPLACE INTO `contas` (`id`,`descricao`,`valor`,`usuario_id`) VALUES (1,'Carteira',-30000,1),(2,'Poupança',0,1),(3,'NuConta',320000,1);

#
# Data for table "categorias"
#

REPLACE INTO `categorias` (`id`,`descricao`,`tipo`,`usuario_id`) VALUES (1,'Salário','Receita',1),(2,'Bônus','Receita',1),(3,'Transporte','Despesa',1),(4,'Saúde','Despesa',1),(5,'Lazer','Despesa',1),(6,'Educação','Despesa',1);

#
# Data for table "receitas"
#

REPLACE INTO `receitas` (`id`,`valor`,`status`,`data`,`descricao`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,200000,'pago','2021-10-05','Pagamento',NULL,1,3,1),(2,50000,'pago','2021-10-05','PPR',NULL,1,1,2),(3,200000,'pago','2021-11-05','Pagamento',NULL,1,3,1),(4,55000,'pago','2021-11-05','PPR',NULL,1,1,2);

#
# Data for table "despesas"
#

REPLACE INTO `despesas` (`id`,`valor`,`status`,`data`,`descricao`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,80000,'pago','2021-10-06','Faculdade',NULL,1,1,3),(2,20000,'pago','2021-10-05','Ônibus Faculdade',NULL,1,1,3),(3,80000,'pago','2021-11-05','Faculdade',NULL,1,3,6),(4,25000,'pago','2021-11-09','Ônibus Faculdade',NULL,1,1,3),(5,10000,'pago','2021-11-18','Dentista',NULL,1,1,4);
