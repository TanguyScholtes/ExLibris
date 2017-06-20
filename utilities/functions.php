<?php

function jsonEncode ( $rawData ) {
    return json_encode( $rawData, JSON_UNESCAPED_UNICODE );
}
