<?php

namespace App\Libraries;

class Validation
{
    public static string $EMAIL = "required|valid_email|max_length[255]";

    public static string $NAME = "required|alpha_space|min_length[3]|max_length[100]";
    public static string $PASSWORD = "required|min_length[8]|max_length[255]";
    public static string $ROLE_NAME = "required|alpha_numeric_space|min_length[3]|max_length[100]";

    public static string $ROLE = "required|numeric";
    public static string $PHONE = "required|numeric|min_length[10]|max_length[15]";

    public static string $ADDRESS = "required|min_length[5]|max_length[255]";
    public static string $CITY = "required|alpha_space|min_length[3]|max_length[100]";
    public static string $ZIP = "required|numeric|min_length[5]|max_length[10]";
    public static string $COUNTRY = "required|alpha_space|min_length[3]|max_length[100]";

    public static string $DATE = "required|valid_date";

    public static string $URL = "required|valid_url|max_length[255]";

    public static string $TEXT = "required|min_length[5]|max_length[1000]";
    public static string $USERNAME = "required|min_length[4]|max_length[20]";
    public static string $STATUS = "required|in_list[active,inactive]";

    public static string $REQUIRED = "required";



}
