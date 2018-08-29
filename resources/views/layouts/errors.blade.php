<?php
/**
 * Created by PhpStorm.
 * User: krame
 * Date: 8/21/2018
 * Time: 6:49 AM
 */
?>

@if (count($errors))
    <div class="alert alert-error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif