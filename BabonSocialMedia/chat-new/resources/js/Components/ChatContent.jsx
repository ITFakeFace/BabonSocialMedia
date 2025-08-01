import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';

const ChatContent = ({ oldMessages, auth, updateMessages, newMsg }) => {
    console.log('ChatContent re-render');
    const [newMessage, setNewMessage] = useState('');
    const [mergedMessages, setMergedMessages] = useState([]);
    const chatContainerRef = useRef(null);
    const receiverId = window.location.pathname.split('/').pop();
    const sortedIds = [auth.id, receiverId].sort();
    const [isTyping, setIsTyping] = useState(false);
    const channel = window.Echo.private(`messenger.${sortedIds[0]}.${sortedIds[1]}`);
    const channel1 = window.Echo.private(`messenger.${sortedIds[0]}.${sortedIds[1]}`);
    const [senderId, setSenderId] = useState();


    useEffect(() => {
        // transformOldToMerged(); tai sai anh Doan lai call no trong day ?
        // Subscribe to the channel when the component mounts
        channel.listen('.MessageSent', (data) => {
            console.log('Received new data:', data);
            let newMsg = data.message;
            let receiver_avatar = data.receiver_avatar;
            let receiver_username = data.receiver_username;
            let sender_avatar = data.sender_avatar;
            let sender_username = data.sender_username;
            // You can update your state or perform any other actions here
            updateMessages({
                id: newMsg.id,
                message: newMsg.message,
                sender_id: newMsg.sender_id,
                receiver_id: newMsg.receiver_id,
                sender_name: sender_username,
                receiver_name: receiver_username,
                receiver_avatar: receiver_avatar,
                sender_avatar: sender_avatar,
                created_at: newMsg.created_at,
                updated_at: newMsg.updated_at,
            });
            chatContainerRef.current.scrollTop = chatContainerRef.current.scrollHeight;
        });

        channel1.listen('.typing', (data) => {
            console.log('TypingEvent:', data);
            setIsTyping(data.isTyping);
            setSenderId(data.senderId);
            chatContainerRef.current.scrollTop = chatContainerRef.current.scrollHeight;
        });
        chatContainerRef.current.scrollTop = chatContainerRef.current.scrollHeight;


        // Unsubscribe from the channel when the component unmounts
        return () => {
            channel.stopListening('.MessageSent');
            channel.stopListening('.typing');
        };
    }, [mergedMessages]);


    useEffect(() => {
        transformOldToMerged();
    }, [oldMessages.length,receiverId]);

    const formatDate = (timestamp) => {
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const formattedTime = new Date(timestamp).toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
            timeZone: 'Asia/Bangkok',
        });
        const dayOfWeek = daysOfWeek[new Date(timestamp).getDay()]; // Get the day of the week

        return `${dayOfWeek} ${formattedTime}`;
    };

    const getCsrfToken = () => {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        return metaTag ? metaTag.getAttribute('content') : '';
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const url = `/chat/${receiverId}`;
        const data = {
            message: newMessage,
        };
        const headers = {
            'X-CSRF-TOKEN': getCsrfToken(),
        };

        axios
            .post(url, data, { headers: headers })
            .then((response) => {
                if (response.status === 200) {
                    console.log('Message sent successfully');
                    setNewMessage('');
                } else {
                    console.error('Failed to send message:', response);
                }
            })
            .catch((error) => {
                console.error('Error sending message:', error);
            });
    };

    const handleKeyDown = (event) => {
        if (event.key === 'Enter' && !event.shiftKey && !event.isComposing) {
            event.preventDefault();
            handleSubmit(event);
            handleTyping(false);
        }
    };
    const handleTyping = (isTyping) => {
        setIsTyping(isTyping);
        let url = '/start-typing'; // URL to trigger startTyping event
        const data = {
            receiverId: parseInt(receiverId),
        };
        console.log('data trong handleTyping',data);
        const headers = {
            'X-CSRF-TOKEN': getCsrfToken(),
        };

        if (isTyping) {
            axios
                .post(url, data, { headers: headers })
                .then((response) => {
                })
                .catch((error) => {
                });
        } else {
            url = '/stop-typing'; // URL to trigger stopTyping event

            axios
                .post(url, data, { headers: headers })
                .then((response) => {
                })
                .catch((error) => {
                });
        }
    };


    console.log('senderId in chatcontent',senderId);
    const transformOldToMerged = () => {
        const newMergedMessages = [];
        let currentSender = null;
        let currentReceiver = null;
        let changeMessage = null;

        oldMessages.forEach((message) => {
            if (message.sender_id && message.receiver_id) {
                if (message.sender_id === currentSender && message.receiver_id === currentReceiver) {
                    changeMessage.messages.push(message);
                } else {
                    // Create a new merged message
                    changeMessage = {
                        sender_id: message.sender_id,
                        receiver_id: message.receiver_id,
                        sender_name: message.sender_name ? message.sender_name : '',
                        sender_avatar: message.sender_avatar,
                        receiver_name: message.receiver_name,
                        receiver_avatar: message.receiver_avatar,
                        messages: [message],
                    };

                    newMergedMessages.push(changeMessage);

                    // Update current sender and receiver
                    currentSender = message.sender_id;
                    currentReceiver = message.receiver_id;
                }
            }
        });

        setMergedMessages(newMergedMessages);
    };
    console.log('This is mergedMessages', mergedMessages);
    return (
        <div className="w-full bg-white flex flex-col pt-[12px] pb-[25px] rounded-lg h-full">
            {/* Chat content */}
            {/* Header */}
            <div className="flex items-center justify-between bg-gray-200 h-[115px] pl-[35px] rounded-tl-xl rounded-tr-xl ">
                <h1 className="text-[#6a65bf] text-[22px]">Chat</h1>
                <div className="p-[51px]">
                    <button className="bg-[#7dd6b4] text-white text-[19px] px-4 py-2 rounded-xl">Messages</button>
                </div>
            </div>
            {/* Chat Content */}
            <div ref={chatContainerRef} className="p-4 flex-grow bg-gray-100 overflow-y-auto" style={{ maxHeight: 'calc(100vh - 200px)' }}>
                {receiverId !== 'chat' ? (
                    mergedMessages.map((mergedMessage, index) => {
                        const isSentByCurrentUser = mergedMessage.sender_id === auth.id;
                        const messageContainerClass = isSentByCurrentUser ? 'justify-end' : 'justify-start';
                        const messageContentClass = isSentByCurrentUser ? 'bg-[#6a65bf] text-white' : 'bg-white text-black';

                        return (
                            <div key={index} className={`flex items-end ${isSentByCurrentUser ? 'justify-end' : 'justify-start'}`}>
                                {!isSentByCurrentUser && (
                                    <img src={`/images/${mergedMessage.sender_avatar}`} alt="Avatar" className="w-8 h-8 rounded-full ml-2 object-cover" />
                                )}
                                <div className="max-w-[60%] h-auto flex flex-col py-2 px-4 ml-2">
                                    {mergedMessage.messages.map((message, index) => (
                                        <div
                                            key={index}
                                            className={`mb-2 ${isSentByCurrentUser ? 'pl-20' : 'pr-20'} ${isSentByCurrentUser ? 'self-end' : 'self-start'}`}
                                        >
                                            {index === 0 && (
                                                <p className="text-[12px] text-[#6a65bf] font-semibold mb-1">
                                                    {isSentByCurrentUser ? 'You' : message.sender_name}, {formatDate(message.created_at)}
                                                </p>
                                            )}
                                            <div
                                                className={`inline-block relative rounded-lg py-[20px] px-[20px] ${messageContentClass}`}
                                                style={{ wordBreak: 'break-word' }}
                                            >
                                                <p className="text-[17px] font-semibold">{message.message}</p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                                {isSentByCurrentUser && (
                                    <img src={`/images/${mergedMessage.sender_avatar}`} alt="Avatar" className="w-8 h-8 rounded-full mr-2 object-cover" />
                                )}
                            </div>
                        );
                    }
                    )
                ) : (
                    <div className="flex items-center justify-center h-full">
                        <p className="text-lg font-semibold">Choose one person to chat</p>
                    </div>
                )}
            </div>
            {/* Messages Box */}
            <div>
                {isTyping && mergedMessages.length > 0 && auth.id !== senderId && (
                    <div className="flex pl-[20px] items-center pt-[20px] bg-gray-100">
                        <span className="animate-pulse w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <p className="text-sm text-gray-500">{ mergedMessages[mergedMessages.length - 1].receiver_name === auth.username ? mergedMessages[mergedMessages.length - 1].sender_name  : mergedMessages[mergedMessages.length - 1].receiver_name } is typing...</p>
                    </div>
                )}
            </div>
            <div className="p-[35px] bg-gray-100 rounded-bl-2xl rounded-br-2xl">
                <div className="relative">
                    <input
                        type="text"
                        className="bg-white text-[17px] font-semibold w-full h-[78px] px-[20px] border border- bg-gray-100 rounded-2xl pr-10"
                        placeholder="Write your message...."
                        onKeyDown={handleKeyDown}
                        value={newMessage}
                        onChange={(e) => {
                            setNewMessage(e.target.value);
                            handleTyping(e.target.value !== '');
                        }}
                    />
                    <span className="absolute inset-y-0 right-[30px] flex items-center">
            <button className="text-gray-400 w-[23px]" onClick={handleSubmit}>
              Send
            </button>
          </span>
                </div>
            </div>
        </div>
    );
};

export default ChatContent;
