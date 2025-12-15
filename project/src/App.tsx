import React, { useState, useRef, useEffect } from 'react';
import { Send, Bot, User, Trash2 } from 'lucide-react';

interface Message {
  id: number;
  text: string;
  sender: 'user' | 'bot';
  timestamp: Date;
}

interface ChatPattern {
  pattern: RegExp;
  responses: string[];
  context?: string;
}

function App() {
  const [messages, setMessages] = useState<Message[]>([
    {
      id: 1,
      text: "Hello! I'm a simple chatbot. I can help you with basic questions and have a conversation. Try asking me about the weather, time, math, or just say hello!",
      sender: 'bot',
      timestamp: new Date()
    }
  ]);
  const [inputText, setInputText] = useState('');
  const [isTyping, setIsTyping] = useState(false);
  const messagesEndRef = useRef<HTMLDivElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);

  const chatPatterns: ChatPattern[] = [
    // Greetings
    {
      pattern: /\b(hello|hi|hey|greetings|good morning|good afternoon|good evening)\b/i,
      responses: [
        "Hello! How can I help you today?",
        "Hi there! What's on your mind?",
        "Hey! Nice to meet you. What would you like to talk about?",
        "Greetings! I'm here to chat. What can I do for you?"
      ]
    },
    
    // Farewells
    {
      pattern: /\b(bye|goodbye|see you|farewell|take care|later)\b/i,
      responses: [
        "Goodbye! It was nice chatting with you.",
        "See you later! Have a great day!",
        "Take care! Feel free to come back anytime.",
        "Farewell! Thanks for the conversation."
      ]
    },
    
    // How are you
    {
      pattern: /\b(how are you|how do you feel|what's up|how's it going)\b/i,
      responses: [
        "I'm doing great! Thanks for asking. How are you?",
        "I'm fantastic! Ready to help you with anything you need.",
        "I'm doing well! What about you?",
        "All systems running smoothly! How can I assist you today?"
      ]
    },
    
    // Name questions
    {
      pattern: /\b(what's your name|who are you|what are you called)\b/i,
      responses: [
        "I'm a simple chatbot created to demonstrate basic conversation patterns!",
        "You can call me ChatBot. I'm here to chat and help with simple questions.",
        "I'm your friendly neighborhood chatbot! What should I call you?"
      ]
    },
    
    // Weather
    {
      pattern: /\b(weather|rain|sunny|cloudy|temperature|hot|cold|snow)\b/i,
      responses: [
        "I wish I could check the weather for you! Try looking outside or checking a weather app.",
        "I don't have access to real weather data, but I hope it's nice where you are!",
        "Weather is always a great conversation starter! What's it like where you are?"
      ]
    },
    
    // Time
    {
      pattern: /\b(time|clock|what time|when|date|today)\b/i,
      responses: [
        `The current time is ${new Date().toLocaleTimeString()}`,
        `Today is ${new Date().toLocaleDateString()}. The time is ${new Date().toLocaleTimeString()}`,
        "Time flies when you're having a good conversation!"
      ]
    },
    
    // Math questions
    {
      pattern: /\b(calculate|math|plus|minus|multiply|divide|\d+\s*[\+\-\*\/]\s*\d+)\b/i,
      responses: [
        "I can do simple math! Try asking me something like '5 + 3' or 'what is 10 times 2?'",
        "Math is fun! Give me a simple calculation and I'll try to help.",
        "I love numbers! What would you like me to calculate?"
      ]
    },
    
    // Simple calculations
    {
      pattern: /(\d+)\s*\+\s*(\d+)/,
      responses: ["Let me calculate that for you..."],
      context: 'addition'
    },
    {
      pattern: /(\d+)\s*\-\s*(\d+)/,
      responses: ["Let me calculate that for you..."],
      context: 'subtraction'
    },
    {
      pattern: /(\d+)\s*\*\s*(\d+)/,
      responses: ["Let me calculate that for you..."],
      context: 'multiplication'
    },
    {
      pattern: /(\d+)\s*\/\s*(\d+)/,
      responses: ["Let me calculate that for you..."],
      context: 'division'
    },
    
    // Compliments
    {
      pattern: /\b(good|great|awesome|amazing|nice|cool|smart|helpful)\b/i,
      responses: [
        "Thank you! That's very kind of you to say.",
        "I appreciate the compliment! You're pretty great yourself.",
        "Aww, thanks! I try my best to be helpful.",
        "You're making me blush! Well, if I could blush..."
      ]
    },
    
    // Questions about capabilities
    {
      pattern: /\b(what can you do|help|capabilities|features)\b/i,
      responses: [
        "I can chat with you, answer simple questions, do basic math, and respond to common conversation topics!",
        "I'm a simple chatbot that can have basic conversations. Try asking about weather, time, or just chat!",
        "I can respond to greetings, answer questions, do simple calculations, and have friendly conversations!"
      ]
    },
    
    // Thank you
    {
      pattern: /\b(thank you|thanks|appreciate)\b/i,
      responses: [
        "You're welcome! Happy to help.",
        "No problem at all! Glad I could assist.",
        "My pleasure! Feel free to ask anything else.",
        "Anytime! That's what I'm here for."
      ]
    }
  ];

  const processUserInput = (input: string): string => {
    const lowerInput = input.toLowerCase().trim();
    
    // Check for math calculations first
    const addMatch = input.match(/(\d+)\s*\+\s*(\d+)/);
    if (addMatch) {
      const result = parseInt(addMatch[1]) + parseInt(addMatch[2]);
      return `${addMatch[1]} + ${addMatch[2]} = ${result}`;
    }
    
    const subMatch = input.match(/(\d+)\s*\-\s*(\d+)/);
    if (subMatch) {
      const result = parseInt(subMatch[1]) - parseInt(subMatch[2]);
      return `${subMatch[1]} - ${subMatch[2]} = ${result}`;
    }
    
    const mulMatch = input.match(/(\d+)\s*\*\s*(\d+)/);
    if (mulMatch) {
      const result = parseInt(mulMatch[1]) * parseInt(mulMatch[2]);
      return `${mulMatch[1]} × ${mulMatch[2]} = ${result}`;
    }
    
    const divMatch = input.match(/(\d+)\s*\/\s*(\d+)/);
    if (divMatch) {
      const divisor = parseInt(divMatch[2]);
      if (divisor === 0) {
        return "I can't divide by zero! That would break the universe!";
      }
      const result = parseInt(divMatch[1]) / divisor;
      return `${divMatch[1]} ÷ ${divMatch[2]} = ${result}`;
    }
    
    // Check other patterns
    for (const pattern of chatPatterns) {
      if (pattern.pattern.test(input)) {
        const responses = pattern.responses;
        return responses[Math.floor(Math.random() * responses.length)];
      }
    }
    
    // Default responses for unmatched input
    const defaultResponses = [
      "That's interesting! Tell me more about that.",
      "I'm not sure I understand completely, but I'm here to listen!",
      "Could you rephrase that? I'd love to help if I can.",
      "That's a great point! What else would you like to talk about?",
      "I'm still learning! Can you ask me something else?",
      "Hmm, that's beyond my current knowledge. Try asking about the weather, time, or math!"
    ];
    
    return defaultResponses[Math.floor(Math.random() * defaultResponses.length)];
  };

  const handleSendMessage = () => {
    if (!inputText.trim()) return;

    const userMessage: Message = {
      id: Date.now(),
      text: inputText,
      sender: 'user',
      timestamp: new Date()
    };

    setMessages(prev => [...prev, userMessage]);
    setInputText('');
    setIsTyping(true);

    // Simulate thinking time
    setTimeout(() => {
      const botResponse = processUserInput(inputText);
      const botMessage: Message = {
        id: Date.now() + 1,
        text: botResponse,
        sender: 'bot',
        timestamp: new Date()
      };

      setMessages(prev => [...prev, botMessage]);
      setIsTyping(false);
    }, Math.random() * 1000 + 500); // Random delay between 500-1500ms
  };

  const handleKeyPress = (e: React.KeyboardEvent) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSendMessage();
    }
  };

  const clearChat = () => {
    setMessages([
      {
        id: 1,
        text: "Chat cleared! I'm still here to help. What would you like to talk about?",
        sender: 'bot',
        timestamp: new Date()
      }
    ]);
  };

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  useEffect(() => {
    scrollToBottom();
  }, [messages]);

  useEffect(() => {
    inputRef.current?.focus();
  }, []);

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
      <div className="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">
        {/* Header */}
        <div className="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6">
          <div className="flex items-center justify-between">
            <div className="flex items-center space-x-3">
              <div className="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <Bot className="w-6 h-6" />
              </div>
              <div>
                <h1 className="text-xl font-bold">Simple ChatBot</h1>
                <p className="text-blue-100 text-sm">Rule-based conversation AI</p>
              </div>
            </div>
            <button
              onClick={clearChat}
              className="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200"
              title="Clear chat"
            >
              <Trash2 className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Messages */}
        <div className="h-96 overflow-y-auto p-6 space-y-4 bg-gray-50">
          {messages.map((message) => (
            <div
              key={message.id}
              className={`flex items-start space-x-3 ${
                message.sender === 'user' ? 'justify-end' : 'justify-start'
              }`}
            >
              {message.sender === 'bot' && (
                <div className="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <Bot className="w-4 h-4 text-white" />
                </div>
              )}
              
              <div
                className={`max-w-xs lg:max-w-md px-4 py-3 rounded-2xl ${
                  message.sender === 'user'
                    ? 'bg-blue-500 text-white rounded-br-md'
                    : 'bg-white text-gray-800 shadow-md rounded-bl-md'
                }`}
              >
                <p className="text-sm leading-relaxed">{message.text}</p>
                <p className={`text-xs mt-2 ${
                  message.sender === 'user' ? 'text-blue-100' : 'text-gray-500'
                }`}>
                  {message.timestamp.toLocaleTimeString([], { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                  })}
                </p>
              </div>

              {message.sender === 'user' && (
                <div className="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <User className="w-4 h-4 text-white" />
                </div>
              )}
            </div>
          ))}
          
          {isTyping && (
            <div className="flex items-start space-x-3">
              <div className="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                <Bot className="w-4 h-4 text-white" />
              </div>
              <div className="bg-white px-4 py-3 rounded-2xl rounded-bl-md shadow-md">
                <div className="flex space-x-1">
                  <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                  <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '0.1s' }}></div>
                  <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '0.2s' }}></div>
                </div>
              </div>
            </div>
          )}
          
          <div ref={messagesEndRef} />
        </div>

        {/* Input */}
        <div className="p-6 bg-white border-t border-gray-200">
          <div className="flex space-x-4">
            <input
              ref={inputRef}
              type="text"
              value={inputText}
              onChange={(e) => setInputText(e.target.value)}
              onKeyPress={handleKeyPress}
              placeholder="Type your message here..."
              className="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
              disabled={isTyping}
            />
            <button
              onClick={handleSendMessage}
              disabled={!inputText.trim() || isTyping}
              className="px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center space-x-2"
            >
              <Send className="w-4 h-4" />
              <span className="font-medium">Send</span>
            </button>
          </div>
          
          <div className="mt-3 text-center">
            <p className="text-xs text-gray-500">
              Try: "Hello", "What time is it?", "5 + 3", "What's the weather like?"
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}

export default App;