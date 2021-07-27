CREATE DATABASE IF NOT EXISTS contas
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_general_ci;

USE contas;

CREATE TABLE IF NOT EXISTS agua(
	data_conta DATE NOT NULL,
    categoria_imovel VARCHAR(15) NOT NULL,
	padrao_imovel VARCHAR(5) NOT NULL,
	leit_anterior MEDIUMINT NOT NULL,
    leit_atual MEDIUMINT NOT NULL,
	volume_m3 TINYINT UNSIGNED NOT NULL,
	media_semestral_m3 TINYINT DEFAULT '0',
	valor_consumo DECIMAL(5,2) NOT NULL,
	multa_porc TINYINT DEFAULT '0',
    val_multa DECIMAL(5,2) DEFAULT '0',
	tarifa_juros DECIMAL(4,3) DEFAULT '0',
    val_juros DECIMAL(5,2) DEFAULT '0',
	religacao DECIMAL(5,2) DEFAULT '0',
	emissao_2via DECIMAL(5,2) DEFAULT '0',
	total DECIMAL(5,2) NOT NULL,
    situacao ENUM('P', 'NP') DEFAULT 'NP',
    observacao TEXT,
    PRIMARY KEY(data_conta)
);

CREATE TABLE IF NOT EXISTS energia(
	data_conta DATE NOT NULL,
    tarifa_band_amar DECIMAL(6,5) DEFAULT '0',
    valor_band_amar DECIMAL(5,2) DEFAULT '0',
    tarifa_band_verm DECIMAL(6,5) DEFAULT '0',
    valor_band_verm DECIMAL(5,2) DEFAULT '0',
    ilum_public DECIMAL(4,2) NOT NULL,
    tarifa_kWh DECIMAL(6,5) NOT NULL,
    valor_consumo DECIMAL(5,2) NOT NULL,
    juros_mora DECIMAL(4,2) DEFAULT '0',
    valor_multa DECIMAL(4,2) DEFAULT '0',
    dic DECIMAL(4,2) DEFAULT '0',
    fic DECIMAL(4,2) DEFAULT '0',
    dmic DECIMAL(4,2) DEFAULT '0',
    dicri DECIMAL(4,2) DEFAULT '0',
    religacao DECIMAL(5,2) DEFAULT '0',
    emissao_2via DECIMAL(5,2) DEFAULT '0',
    total DECIMAL(5,2) NOT NULL,
    leit_anterior MEDIUMINT NOT NULL,
    leit_atual MEDIUMINT NOT NULL,
    consumo_kWh TINYINT UNSIGNED NOT NULL,
    situacao ENUM('P','NP') DEFAULT 'NP',
    observacao TEXT,
    PRIMARY KEY(data_conta)
);

CREATE TABLE IF NOT EXISTS variadas(
	id SMALLINT NOT NULL AUTO_INCREMENT,
	data_conta DATE NOT NULL,
    nome VARCHAR(50) NOT NULL,
    valor DECIMAL(7,2) NOT NULL,
    situacao ENUM('P', 'NP') DEFAULT 'NP',
    observacao TEXT,
    PRIMARY KEY(id)
);
