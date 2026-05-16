<?php

namespace App\Http\Controllers;

/**
 * NewsController - ZooSphere
 * Displays conservation news and wildlife articles
 */
class NewsController extends Controller
{
    /**
     * Display conservation news page
     */
    public function index()
    {
        // Static conservation news articles (in production, these would come from an API or CMS)
        $articles = [
            [
                'title' => 'Giant Panda Population Shows Recovery Signs',
                'excerpt' => 'The giant panda population has grown by 17% in the last decade, with over 1,800 individuals now living in the wild.',
                'content' => 'Conservation efforts in China have led to a significant recovery in the wild giant panda population. Habitat restoration and anti-poaching measures have been key to this success.',
                'image' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=600',
                'date' => '2024-12-15',
                'category' => 'Conservation Success',
                'source' => 'WWF',
            ],
            [
                'title' => 'Ocean Plastic Pollution Threatens Marine Wildlife',
                'excerpt' => 'Over 100 million marine animals are killed by plastic pollution every year. New initiatives aim to reduce ocean waste.',
                'content' => 'Marine conservation organizations are launching ambitious programs to clean up ocean plastics and protect endangered marine species from this growing threat.',
                'image' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=600',
                'date' => '2024-12-10',
                'category' => 'Marine Conservation',
                'source' => 'National Geographic',
            ],
            [
                'title' => 'Tiger Conservation: A Decade of Progress',
                'excerpt' => 'For the first time in 100 years, wild tiger numbers are increasing. India alone is home to 70% of the world\'s tigers.',
                'content' => 'Thanks to coordinated international conservation efforts, the global wild tiger population has increased from 3,200 to over 4,500 individuals.',
                'image' => '/images/tiger.jpg',
                'date' => '2024-12-05',
                'category' => 'Endangered Species',
                'source' => 'IUCN',
            ],
            [
                'title' => 'New Protected Marine Area Established in Pacific',
                'excerpt' => 'A new 500,000 square kilometer marine protected area has been established to safeguard critical ocean habitats.',
                'content' => 'The new marine protected area will serve as a sanctuary for numerous endangered species including sea turtles, whales, and coral reef ecosystems.',
                'image' => 'https://images.unsplash.com/photo-1607153333879-c174d265f1d2?w=600',
                'date' => '2024-11-28',
                'category' => 'Habitat Protection',
                'source' => 'Ocean Conservancy',
            ],
            [
                'title' => 'Arctic Ice Loss Accelerating, Threatening Polar Wildlife',
                'excerpt' => 'Climate change is causing polar ice to melt at unprecedented rates, putting polar bears and arctic species at risk.',
                'content' => 'Scientists report that Arctic sea ice extent has decreased by 13% per decade since the 1970s, dramatically impacting the habitat of polar bears, arctic foxes, and numerous marine mammals.',
                'image' => 'https://images.unsplash.com/photo-1551415923-a2297c7fda79?w=600',
                'date' => '2024-11-20',
                'category' => 'Climate Change',
                'source' => 'NASA Earth Observatory',
            ],
            [
                'title' => 'Elephant Corridor Restoration Project Launched in Kenya',
                'excerpt' => 'A major project to restore ancient elephant migration corridors will connect fragmented habitats across East Africa.',
                'content' => 'The ambitious project aims to reconnect 12 protected areas through habitat corridors, allowing elephants and other large mammals to safely migrate and maintain genetic diversity.',
                'image' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=600',
                'date' => '2024-11-15',
                'category' => 'Wildlife Corridors',
                'source' => 'Wildlife Direct',
            ],
        ];

        return view('news', compact('articles'));
    }
}
