import '../../../css/app.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Sidebar from "@/Components/Sidebar.jsx";
import UserColumn from "@/Components/UserColumn.jsx";
import ChatContent from "@/Components/ChatContent.jsx";
import React, {useEffect, useState} from "react";

export default function Chat(props) {
    console.log(props.recentMessages);
    console.log(props.messages);
    console.log(props);
    const [newMessage, setNewMessage] = useState('');
    const [recentMessages, setRecentMessages] = useState(props.recentMessages);
    const [oldMessages, setOldMessages] = useState(props.messages);

    const updateMessages = (newMsg) => {
        setNewMessage(newMsg);
    };
    console.log('oldMessage:',oldMessages);
    console.log('recentMessages:',recentMessages);

    useEffect(() => {
        console.log('newMessage:',newMessage);
        // console.log('Old Messages:', oldMessages);
        // Add new message to old-messages
        if (newMessage !== '') {
            setOldMessages((prevState) => [...prevState, newMessage]);

            // Add new message to recent messages
            // dua tren cai receiver_id, de ma update dung cai thang do thoi
            if ( recentMessages.length === 0) {
                setRecentMessages([
                    {
                        user_id: newMessage.receiver_id,
                        message: newMessage.message,
                        created_at: newMessage.created_at,
                        avatar: newMessage.receiver_avatar,
                        username: newMessage.receiver_name,
                    }
                ]);
            } else {
                setRecentMessages((prevState) => {
                    const messageIndex = prevState.findIndex(
                        (message) => (message.user_id === newMessage.receiver_id || message.user_id === newMessage.sender_id)
                    );

                    if (messageIndex !== -1) {
                        const updatedMessage = {
                            ...prevState[messageIndex],
                            message: newMessage.message,
                            created_at: newMessage.created_at,
                        };

                        const updatedRecentMessages = [
                            updatedMessage,
                            ...prevState.slice(0, messageIndex),
                            ...prevState.slice(messageIndex + 1),
                        ];

                        return updatedRecentMessages;
                    }

                    // Return prevState if messageIndex is not found or handle it separately
                    return prevState;
                });
            }
        }
    }, [newMessage]);

    return (
        <div className="flex flex-col md:flex-row h-screen pr-[20px] ">
            <Sidebar auth={props.auth} />
            <div className="border-grey-300 border-l h-full"></div>
            <UserColumn recentMessages={recentMessages} auth={props.auth} friends={props.Friend}/>
            <ChatContent oldMessages={oldMessages} auth={props.auth} updateMessages={updateMessages} newMsg={newMessage}/>
        </div>
    );
}
{/*<div className="flex items-center justify-start bg-gray-200 p-[12px] rounded-br-xl">*/}
{/*    <input*/}
{/*        type="text"*/}
{/*        placeholder="Type your message"*/}
{/*        className="w-[80%] h-[50px] rounded-l-xl rounded-r-[50px] border border-gray-300 px-4"*/}
{/*    />*/}
{/*    <button className="bg-[#6a65bf] text-white px-4 py-2 rounded-l-[50px] rounded-r-xl ml-2">*/}
{/*        <i className="fas fa-paper-plane"></i>*/}
{/*    </button>*/}
{/*</div>*/}
