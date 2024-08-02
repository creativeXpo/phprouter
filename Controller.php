<?php 

/**
 * SiteController class for handling site-specific routes
 */
class SiteController
{
    /**
     * Displays the home page
     */
    public function home(): void
    {
        echo "Home page!";
    }

    /**
     * Displays the about page
     */
    public function about(): void
    {
        echo "About page!";
    }
}