<?php

interface PhotoInterface {

    public function cropForMobile($imgPath, $imgName);

    public function cropForDesktop($imgPath, $imgName);
}
