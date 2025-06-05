<?php
define( 'DB_NAME', 'coches_db' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', '172.21.0.2' );
define( 'DB_CHARSET', 'utf8mb4' );
define('DB_COLLATE', '');

$table_prefix = 'wp_';

define('WP_DEBUG', false);

define( 'AUTH_KEY',         'SMuz({i+f@HXM smM=%$MwaBw@H0Ar][R6C #~Cx|IT!?T$B90s(Yfk9vM1DX ]i' );
define( 'SECURE_AUTH_KEY',  'h|Cl.M;-3Sz@k<~qnr#A4g8_hpt%qs*c:LL?J3apf.FIAk/2+6/]#%z./=FNN[bu' );
define( 'LOGGED_IN_KEY',    'WWB*Oa1 Yun&OKaO:lYNwHAm7H)01Ms_o|[9cp CAAiS0[*%/K$U6A}aELuaV-7P' );
define( 'NONCE_KEY',        '(NIG]78uIjhmTEekiLfsVIs<tu:<rT|u0c5/:=_!-[o*9v=ZH>Y7$02/C}f3V;,c' );
define( 'AUTH_SALT',        'QASR6yfV evy5Sv*;VWNE`cp;}fcoZuyEoBorjUIZ}c-0XFM,JF~#[[x}%qY0QB6' );
define( 'SECURE_AUTH_SALT', '}ckV1;G4kN^,bSgMU)xb/6XbZM~ry4],fqDiknifGKy}1H7jp6-Zv>Fp-C7y:h)L' );
define( 'LOGGED_IN_SALT',   'GgzHTB/:0OSAg<!NP<8cis,NE!*x%2AiBiCgrh>IVO$knpdP(~GV&E5TfcI_v1mJ' );
define( 'NONCE_SALT',       '`5KA3ES}[(qmnVfaTJDsQeL3`DG@lEW 8DJe |AEw}Gm(:c==ZI;^Gl2H=Go2Sn2' );

if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
define('FS_METHOD', 'direct');
