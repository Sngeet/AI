import re
import random
import datetime
from typing import List, Dict, Tuple

class SimpleChatBot:
    def __init__(self):
        self.name = "Simple ChatBot"
        self.conversation_history = []
        self.chat_patterns = self._initialize_patterns()
        
    def _initialize_patterns(self) -> List[Dict]:
        """Initialize all conversation patterns and responses"""
        return [
            # Greetings
            {
                'pattern': re.compile(r'\b(hello|hi|hey|greetings|good morning|good afternoon|good evening)\b', re.IGNORECASE),
                'responses': [
                    "Hello! How can I help you today?",
                    "Hi there! What's on your mind?",
                    "Hey! Nice to meet you. What would you like to talk about?",
                    "Greetings! I'm here to chat. What can I do for you?"
                ]
            },
            
            # Farewells
            {
                'pattern': re.compile(r'\b(bye|goodbye|see you|farewell|take care|later|quit|exit)\b', re.IGNORECASE),
                'responses': [
                    "Goodbye! It was nice chatting with you.",
                    "See you later! Have a great day!",
                    "Take care! Feel free to come back anytime.",
                    "Farewell! Thanks for the conversation."
                ],
                'action': 'exit'
            },
            
            # How are you
            {
                'pattern': re.compile(r'\b(how are you|how do you feel|what\'s up|how\'s it going)\b', re.IGNORECASE),
                'responses': [
                    "I'm doing great! Thanks for asking. How are you?",
                    "I'm fantastic! Ready to help you with anything you need.",
                    "I'm doing well! What about you?",
                    "All systems running smoothly! How can I assist you today?"
                ]
            },
            
            # Name questions
            {
                'pattern': re.compile(r'\b(what\'s your name|who are you|what are you called)\b', re.IGNORECASE),
                'responses': [
                    "I'm a simple chatbot created to demonstrate basic conversation patterns!",
                    "You can call me ChatBot. I'm here to chat and help with simple questions.",
                    "I'm your friendly neighborhood chatbot! What should I call you?"
                ]
            },
            
            # Weather
            {
                'pattern': re.compile(r'\b(weather|rain|sunny|cloudy|temperature|hot|cold|snow)\b', re.IGNORECASE),
                'responses': [
                    "I wish I could check the weather for you! Try looking outside or checking a weather app.",
                    "I don't have access to real weather data, but I hope it's nice where you are!",
                    "Weather is always a great conversation starter! What's it like where you are?"
                ]
            },
            
            # Time
            {
                'pattern': re.compile(r'\b(time|clock|what time|when|date|today)\b', re.IGNORECASE),
                'responses': [
                    f"The current time is {datetime.datetime.now().strftime('%I:%M %p')}",
                    f"Today is {datetime.datetime.now().strftime('%B %d, %Y')}. The time is {datetime.datetime.now().strftime('%I:%M %p')}",
                    "Time flies when you're having a good conversation!"
                ]
            },
            
            # Math questions
            {
                'pattern': re.compile(r'\b(calculate|math|plus|minus|multiply|divide)\b', re.IGNORECASE),
                'responses': [
                    "I can do simple math! Try asking me something like '5 + 3' or 'what is 10 times 2?'",
                    "Math is fun! Give me a simple calculation and I'll try to help.",
                    "I love numbers! What would you like me to calculate?"
                ]
            },
            
            # Compliments
            {
                'pattern': re.compile(r'\b(good|great|awesome|amazing|nice|cool|smart|helpful)\b', re.IGNORECASE),
                'responses': [
                    "Thank you! That's very kind of you to say.",
                    "I appreciate the compliment! You're pretty great yourself.",
                    "Aww, thanks! I try my best to be helpful.",
                    "You're making me blush! Well, if I could blush..."
                ]
            },
            
            # Questions about capabilities
            {
                'pattern': re.compile(r'\b(what can you do|help|capabilities|features)\b', re.IGNORECASE),
                'responses': [
                    "I can chat with you, answer simple questions, do basic math, and respond to common conversation topics!",
                    "I'm a simple chatbot that can have basic conversations. Try asking about weather, time, or just chat!",
                    "I can respond to greetings, answer questions, do simple calculations, and have friendly conversations!"
                ]
            },
            
            # Thank you
            {
                'pattern': re.compile(r'\b(thank you|thanks|appreciate)\b', re.IGNORECASE),
                'responses': [
                    "You're welcome! Happy to help.",
                    "No problem at all! Glad I could assist.",
                    "My pleasure! Feel free to ask anything else.",
                    "Anytime! That's what I'm here for."
                ]
            }
        ]
    
    def _calculate_math(self, user_input: str) -> str:
        """Handle mathematical calculations"""
        # Addition
        add_match = re.search(r'(\d+)\s*\+\s*(\d+)', user_input)
        if add_match:
            result = int(add_match.group(1)) + int(add_match.group(2))
            return f"{add_match.group(1)} + {add_match.group(2)} = {result}"
        
        # Subtraction
        sub_match = re.search(r'(\d+)\s*\-\s*(\d+)', user_input)
        if sub_match:
            result = int(sub_match.group(1)) - int(sub_match.group(2))
            return f"{sub_match.group(1)} - {sub_match.group(2)} = {result}"
        
        # Multiplication
        mul_match = re.search(r'(\d+)\s*[\*x×]\s*(\d+)', user_input)
        if mul_match:
            result = int(mul_match.group(1)) * int(mul_match.group(2))
            return f"{mul_match.group(1)} × {mul_match.group(2)} = {result}"
        
        # Division
        div_match = re.search(r'(\d+)\s*[\/÷]\s*(\d+)', user_input)
        if div_match:
            divisor = int(div_match.group(2))
            if divisor == 0:
                return "I can't divide by zero! That would break the universe!"
            result = int(div_match.group(1)) / divisor
            if result.is_integer():
                result = int(result)
            return f"{div_match.group(1)} ÷ {div_match.group(2)} = {result}"
        
        return None
    
    def process_input(self, user_input: str) -> Tuple[str, bool]:
        """Process user input and return response and continue flag"""
        user_input = user_input.strip()
        
        # Store conversation
        self.conversation_history.append(('user', user_input, datetime.datetime.now()))
        
        # Check for math calculations first
        math_result = self._calculate_math(user_input)
        if math_result:
            response = math_result
        else:
            # Check patterns
            response = None
            should_exit = False
            
            for pattern_dict in self.chat_patterns:
                if pattern_dict['pattern'].search(user_input):
                    response = random.choice(pattern_dict['responses'])
                    if pattern_dict.get('action') == 'exit':
                        should_exit = True
                    break
            
            # Default responses for unmatched input
            if not response:
                default_responses = [
                    "That's interesting! Tell me more about that.",
                    "I'm not sure I understand completely, but I'm here to listen!",
                    "Could you rephrase that? I'd love to help if I can.",
                    "That's a great point! What else would you like to talk about?",
                    "I'm still learning! Can you ask me something else?",
                    "Hmm, that's beyond my current knowledge. Try asking about the weather, time, or math!"
                ]
                response = random.choice(default_responses)
        
        # Store bot response
        self.conversation_history.append(('bot', response, datetime.datetime.now()))
        
        # Check if user wants to exit
        exit_patterns = ['bye', 'goodbye', 'quit', 'exit', 'see you', 'farewell']
        should_exit = any(pattern in user_input.lower() for pattern in exit_patterns)
        
        return response, should_exit
    
    def display_welcome(self):
        """Display welcome message"""
        print("=" * 60)
        print(f"🤖 Welcome to {self.name}!")
        print("=" * 60)
        print("I'm a rule-based chatbot that can:")
        print("• Have conversations and answer questions")
        print("• Perform basic math calculations (e.g., '5 + 3', '10 * 2')")
        print("• Tell you the current time and date")
        print("• Respond to greetings and common phrases")
        print("\nTry saying: 'Hello', 'What time is it?', '15 + 25', or 'What can you do?'")
        print("Type 'bye', 'quit', or 'exit' to end the conversation.")
        print("-" * 60)
    
    def display_conversation_stats(self):
        """Display conversation statistics"""
        if len(self.conversation_history) > 2:  # More than just welcome messages
            user_messages = len([msg for msg in self.conversation_history if msg[0] == 'user'])
            bot_messages = len([msg for msg in self.conversation_history if msg[0] == 'bot'])
            
            print(f"\n📊 Conversation Summary:")
            print(f"   • You sent {user_messages} messages")
            print(f"   • I sent {bot_messages} responses")
            print(f"   • Total conversation length: {len(self.conversation_history)} messages")
    
    def run(self):
        """Main chat loop"""
        self.display_welcome()
        
        try:
            while True:
                # Get user input
                user_input = input("\n💬 You: ").strip()
                
                if not user_input:
                    print("🤖 Bot: Please say something! I'm here to chat.")
                    continue
                
                # Process input and get response
                response, should_exit = self.process_input(user_input)
                
                # Display bot response
                print(f"🤖 Bot: {response}")
                
                # Exit if needed
                if should_exit:
                    self.display_conversation_stats()
                    break
                    
        except KeyboardInterrupt:
            print(f"\n\n🤖 Bot: Goodbye! Thanks for chatting with me.")
            self.display_conversation_stats()
        except Exception as e:
            print(f"\n❌ An error occurred: {e}")
            print("🤖 Bot: Sorry, something went wrong. Goodbye!")

def main():
    """Main function to run the chatbot"""
    chatbot = SimpleChatBot()
    chatbot.run()

if __name__ == "__main__":
    main()