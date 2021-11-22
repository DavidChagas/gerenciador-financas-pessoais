# Host: localhost  (Version 5.5.5-10.4.14-MariaDB)
# Date: 2021-11-21 21:51:05
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

REPLACE INTO `users` (`id`,`nome`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'David Chagas','davidmdchagas@hotmail.com',NULL,'$2y$10$fYHHXvVeKHv97yuJOf6dXu4loFdQuFZS89crmvKkM.v7slcliBxb2',NULL,'2021-11-22 00:19:34','2021-11-22 00:19:34');

#
# Data for table "objetivos"
#

REPLACE INTO `objetivos` (`id`,`nome`,`descricao`,`valor`,`data_inicial`,`data_final`,`usuario_id`) VALUES (1,'Comprar um Celular',NULL,600000,'2021-11-22','2022-04-01',1);

#
# Data for table "objetivo_aportes"
#

REPLACE INTO `objetivo_aportes` (`id`,`valor`,`data`,`objetivo_id`) VALUES (1,100000,'2021-11-21',1),(2,400000,'2021-11-21',1);

#
# Data for table "contas"
#

REPLACE INTO `contas` (`id`,`descricao`,`valor`,`usuario_id`) VALUES (1,'Carteira',54950,1),(2,'NuConta',240000,1);

#
# Data for table "categorias"
#

REPLACE INTO `categorias` (`id`,`descricao`,`tipo`,`usuario_id`) VALUES (1,'Salário','Receita',1),(2,'Transporte','Despesa',1),(3,'Alimentação','Despesa',1),(4,'Lazer','Despesa',1);

#
# Data for table "receitas"
#

REPLACE INTO `receitas` (`id`,`valor`,`status`,`data`,`descricao`,`receita_fixa`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,200000,'pago','2021-11-05','Pagamento','sim',NULL,1,2,1);
