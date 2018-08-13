<?php

function rupiah($nilai)
{
    return "Rp. ". number_format(ceil($nilai), "0",",",".");
}