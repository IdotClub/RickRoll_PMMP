<?php

class Utils {
	public const OS_WINDOWS = "win";
	public const OS_IOS = "ios";
	public const OS_MACOS = "mac";
	public const OS_ANDROID = "android";
	public const OS_LINUX = "linux";
	public const OS_BSD = "bsd";
	public const OS_UNKNOWN = "other";
	private static $os;

	public static function getOS() : string {
		$uname = PHP_OS;
		if (stripos($uname, "Darwin") !== false) {
			if (strpos(php_uname("m"), "iP") === 0) {
				self::$os = self::OS_IOS;
			} else {
				self::$os = self::OS_MACOS;
			}
		} elseif ($uname === "Msys" || stripos($uname, "Win") !== false) {
			self::$os = self::OS_WINDOWS;
		} elseif (stripos($uname, "Linux") !== false) {
			if (@file_exists("/system/build.prop")) {
				self::$os = self::OS_ANDROID;
			} else {
				self::$os = self::OS_LINUX;
			}
		} elseif ($uname === "DragonFly" || stripos($uname, "BSD") !== false) {
			self::$os = self::OS_BSD;
		} else {
			self::$os = self::OS_UNKNOWN;
		}
		return self::$os;
	}
}

//$video = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
$video = "https://www.bilibili.com/video/BV1GJ411x7h7";
switch (Utils::getOS()) {
	case Utils::OS_MACOS:
		//shell_exec("say never gonna give you, this is just a joke, time to cry.");
		shell_exec("say 呜哇呜你被骗了");
		shell_exec("open $video");
		break;
	case Utils::OS_LINUX:
	case Utils::OS_BSD:
		if (trim(shell_exec("which xdg-open")) === "") {
			echo "Give Your System UP";
			return;
		}
		shell_exec("xdg-open $video");
		break;
	case Utils::OS_WINDOWS:
		shell_exec("cmd /C start $video");
		break;
	default:
		echo "Give You UP";
}