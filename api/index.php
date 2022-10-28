<?php
/**
 * 获取公共 IP 地址
 *
 * @return string|false 公共 IP 地址
 */
function getIP(): string|bool {
	foreach (
		[
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		]
		as $key
	) {
		if (array_key_exists($key, $_SERVER)) {
			foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
				return filter_var(
					$ip,
					FILTER_VALIDATE_IP,
					FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
				);
			}
		}
	}
	return false;
}

header('Content-Type: text/plain; charset=utf-8');
exit(getIP()); // Output IP address [Ex: 123.45.67.89]
?>
