<?php
class PriceHelper extends AppHelper {
    function formatPrice($price) {
        $price = round(floatval($price),2);
		$price = number_format($price, 2, ',', '');
        $price .= ' EUR';
        return $price;
    }
}
?>