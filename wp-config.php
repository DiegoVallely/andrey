<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'andreybraga' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'abraga_admin' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'AdRyE8p2bcVcyge' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Uxz+8#x@Yo?Hq-iNC}&,!jb#ECTgEana^ll2:MAwU)!|BbhWKO.k><q([;F7=4b@' );
define( 'SECURE_AUTH_KEY',  'N/jda3B_fC9X!cf]%s$@B|z_I!#E!Se54x~(i@cg/=mP p8qfnI;dL2_3$Q4SCH=' );
define( 'LOGGED_IN_KEY',    '!:C1Bu>aCjf73;C#YE~PR)2DUkxkqb`RhW$/#0#DVqJvzp2gw>CMF+K:?^a,1f>X' );
define( 'NONCE_KEY',        '6#7^T*Zan}=-O:pfLo!B6xH2PZoD:|aUUSsGRndB}U+XUQ^bu>>.fPJ}]+(!b;J|' );
define( 'AUTH_SALT',        'pP%*_l:,5s~O,0?f+R=U:9-%N),o@Q]XV^Xf@l[MZ{h$*aMDY0KR3Q{ryc^Ie&EC' );
define( 'SECURE_AUTH_SALT', 'Fw%^tvmLjLBZd2~4jpYs/+vm*C&LBETSm2%p7}@LnoMWRyK ie0t]pr4If x?u.-' );
define( 'LOGGED_IN_SALT',   'P2c_1WTpu->p(XFw6L&S/R=((idT=F|G.gR?bIzE-Bpri&Jqe~E9>O{]|m1-XdO2' );
define( 'NONCE_SALT',       'J=]t@%&kx]_isM/{AAXmy95tB>!}9g3sL4:O=>cO>&yF%aCx{)5ODI 3kKK@Ny,;' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'ab_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);
define('WP_MEMORY_LIMIT', '256M');
define('FS_METHOD','direct');

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
