<?php
namespace JP;
use JP\Get;


class Put
{

    public static function phoneNumberLink($options = [])
	{
        echo Get::phoneNumberLink($options);
	}

	public static function phoneNumberTel($options = [])
	{
		echo Get::phoneNumberTel($options);
	}

	public static function phoneNumber()
	{
		echo Get::phoneNumber();
	}

    public static function image_html( $args=[] ){
        echo Get::image_html($args);
    }


}
