<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

/**
 * ChatbotController - ZooSphere
 * AI Animal Chatbot - answers questions about animals using local knowledge base
 */
class ChatbotController extends Controller
{
    /**
     * Display the chatbot page
     */
    public function index()
    {
        return view('chatbot');
    }

    /**
     * Process chatbot message and return AI-like response
     */
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = strtolower($request->message);
        $response = $this->generateResponse($message);

        return response()->json([
            'response' => $response,
        ]);
    }

    /**
     * Generate intelligent response based on local animal knowledge base
     */
    private function generateResponse(string $message): string
    {
        // Try to find an animal mentioned in the message
        $animals = Animal::all();
        $matchedAnimal = null;

        foreach ($animals as $animal) {
            if (str_contains($message, strtolower($animal->name)) ||
                str_contains($message, strtolower($animal->species))) {
                $matchedAnimal = $animal;
                break;
            }
        }

        // Diet questions
        if (str_contains($message, 'eat') || str_contains($message, 'diet') || str_contains($message, 'food')) {
            if ($matchedAnimal) {
                $facts = $this->getDietInfo($matchedAnimal);
                return $facts;
            }
            return "🍽️ Animals have different diets! We have **Carnivores** (meat eaters like lions), **Herbivores** (plant eaters like elephants), and **Omnivores** (both, like bears). Ask me about a specific animal!";
        }

        // Habitat questions
        if (str_contains($message, 'live') || str_contains($message, 'habitat') || str_contains($message, 'where') || str_contains($message, 'home')) {
            if ($matchedAnimal) {
                return "🌍 **{$matchedAnimal->name}** lives in the **{$matchedAnimal->habitat->name}** habitat. {$matchedAnimal->habitat->description}";
            }
            return "🌍 Our zoo has 5 amazing habitats: **Forest** 🌲, **Desert** 🏜️, **Ocean** 🌊, **Arctic** ❄️, and **Savannah** 🌾. Which habitat would you like to explore?";
        }

        // Lifespan questions
        if (str_contains($message, 'long') || str_contains($message, 'lifespan') || str_contains($message, 'age') || str_contains($message, 'old')) {
            if ($matchedAnimal) {
                return "⏳ The **{$matchedAnimal->name}** ({$matchedAnimal->scientific_name}) typically lives for **{$matchedAnimal->lifespan}** in the wild.";
            }
            return "⏳ Different animals have very different lifespans! Elephants can live 60-70 years, while some insects only live a day. Ask me about a specific animal!";
        }

        // Conservation / endangered questions
        if (str_contains($message, 'endangered') || str_contains($message, 'conservation') || str_contains($message, 'extinct') || str_contains($message, 'status')) {
            if ($matchedAnimal) {
                return "🛡️ The **{$matchedAnimal->name}** currently has a conservation status of **{$matchedAnimal->conservation_status}**. We must work together to protect all wildlife!";
            }
            return "🛡️ Conservation is crucial! Many animals in our zoo are endangered or vulnerable. Tigers are **Endangered**, Elephants are **Vulnerable**. Ask about a specific animal's conservation status!";
        }

        // Fun facts
        if (str_contains($message, 'fact') || str_contains($message, 'interesting') || str_contains($message, 'fun') || str_contains($message, 'cool') || str_contains($message, 'tell me')) {
            if ($matchedAnimal && $matchedAnimal->fun_facts) {
                $facts = is_array($matchedAnimal->fun_facts) ? $matchedAnimal->fun_facts : json_decode($matchedAnimal->fun_facts, true);
                if ($facts && count($facts) > 0) {
                    $randomFact = $facts[array_rand($facts)];
                    return "🌟 **Fun Fact about {$matchedAnimal->name}:** {$randomFact}";
                }
            }
            return "🌟 Here's a fun fact: A group of flamingos is called a **'flamboyance'**! Ask me about any animal for more fun facts!";
        }

        // Speed / size questions
        if (str_contains($message, 'fast') || str_contains($message, 'speed') || str_contains($message, 'big') || str_contains($message, 'weight') || str_contains($message, 'tall') || str_contains($message, 'heavy')) {
            if ($matchedAnimal) {
                $info = "📏 **{$matchedAnimal->name} Stats:**\n";
                if ($matchedAnimal->weight) $info .= "• Weight: {$matchedAnimal->weight}\n";
                if ($matchedAnimal->height) $info .= "• Height: {$matchedAnimal->height}\n";
                if ($matchedAnimal->speed) $info .= "• Speed: {$matchedAnimal->speed}\n";
                return $info;
            }
            return "📏 The fastest land animal is the **Cheetah** at 120 km/h, and the largest is the **Blue Whale** at 150 tons! Ask about a specific animal!";
        }

        // If animal is mentioned but no specific question
        if ($matchedAnimal) {
            return "🦁 **{$matchedAnimal->name}** ({$matchedAnimal->scientific_name})\n\n{$matchedAnimal->description}\n\n📊 **Quick Facts:**\n• Diet: {$matchedAnimal->diet}\n• Lifespan: {$matchedAnimal->lifespan}\n• Status: {$matchedAnimal->conservation_status}\n• Habitat: {$matchedAnimal->habitat->name}\n\nWant to know more? Ask about its diet, habitat, fun facts, or conservation status!";
        }

        // Greetings
        if (str_contains($message, 'hello') || str_contains($message, 'hi') || str_contains($message, 'hey') || str_contains($message, 'howdy')) {
            return "👋 Hello! Welcome to **ZooSphere AI Assistant**! 🌿\n\nI can help you learn about animals in our zoo. Try asking:\n• \"What do lions eat?\"\n• \"Tell me about tigers\"\n• \"Where do penguins live?\"\n• \"Fun facts about elephants\"\n• \"Is the panda endangered?\"";
        }

        // Help
        if (str_contains($message, 'help') || str_contains($message, 'what can')) {
            return "🤖 I'm the **ZooSphere AI Assistant**! Here's what I can help with:\n\n🍽️ **Diet** — \"What do [animal] eat?\"\n🌍 **Habitat** — \"Where do [animal] live?\"\n⏳ **Lifespan** — \"How long do [animal] live?\"\n🛡️ **Conservation** — \"Is [animal] endangered?\"\n🌟 **Fun Facts** — \"Tell me a fact about [animal]\"\n📏 **Stats** — \"How fast/big is [animal]?\"\n\nJust mention any animal name in your question!";
        }

        // Default response
        return "🌿 I'm not sure I understood that. Try asking about a specific animal! For example:\n• \"Tell me about the lion\"\n• \"What do elephants eat?\"\n• \"Fun facts about dolphins\"\n\nType **\"help\"** to see all my capabilities!";
    }

    /**
     * Get diet information for an animal
     */
    private function getDietInfo(Animal $animal): string
    {
        $dietDetails = [
            'Carnivore' => 'meat, fish, and other animals',
            'Herbivore' => 'plants, leaves, fruits, and vegetation',
            'Omnivore' => 'both plants and meat',
        ];

        $dietDesc = $dietDetails[$animal->diet] ?? $animal->diet;

        return "🍽️ **{$animal->name}** is a **{$animal->diet}**, which means it eats {$dietDesc}. In the wild, {$animal->name}s are " .
            ($animal->diet === 'Carnivore' ? 'skilled hunters that prey on other animals.' :
            ($animal->diet === 'Herbivore' ? 'gentle grazers that spend much of their day foraging for food.' :
            'adaptable feeders that eat whatever is available in their environment.'));
    }
}
