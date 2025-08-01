import React, {useState} from 'react';
import SearchBar from '@/Components/SearchBar.jsx';
export default function UserColumn  ( {recentMessages,auth, friends } ) {
    const [selectedFriend, setSelectedFriend] = useState(null);
    const formatDate = (timestamp) => {
        const date = new Date(timestamp);
        const formattedTime = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Bangkok' });
        return formattedTime;
    };
    const handleSearch = (searchTerm) => {
        // Implement your search logic here
        console.log('Search term:', searchTerm);
        const friend = friends.find((friend) => friend.friendName === searchTerm);
        setSelectedFriend(friend);
    };
    const [status, setStatus] = useState('available');

    const handleStatusChange = (event) => {
        setStatus(event.target.value);
    };

    const getStatusColor = () => {
        if (status === 'busy') {
            return 'text-white bg-red-500';
        } else if (status === 'invisible') {
            return 'text-black bg-gray-500';
        } else {
            return 'text-white bg-[#7dd6b4]';
        }
    };

    return (
        <div className="w-full md:w-[442px] bg-white h-full">
            {/* User column content */}
            {/* user header */}
            <div className="flex items-center px-4 pt-[52px]">
                <h2 className="text-[22px] text-[#6a65bf] ml-[12px]">Chat</h2>
            </div>
            <div className="border-b border-gray-300 pt-[42px] mx-[33px] "></div>
            {/* user info */}
            <div className="flex flex-col justify-center items-center">
                <div className="pt-[38px]">
                    <img src={`/images/${auth.avatar}`} alt="Large Avatar" className="w-[125px] h-[125px] rounded-full object-cover" />
                </div>

                <div className="p-[20px]">
                    <p className="font-bold text-[23px] text-[#6a65bf]">
                        {auth && auth.username ? auth.username : 'N/A'}
                    </p>
                </div>


                <div className="relative">
                    <select
                        id="status-select"
                        className={`text-[15px] justify-center flex w-[131px] h-[40px] rounded-xl border-none ${getStatusColor()}`}
                        value={status}
                        onChange={handleStatusChange}
                    >
                        <option value="available">Available</option>
                        <option value="invisible">Invisible</option>
                        <option value="busy">Busy</option>
                    </select>
                </div>
            </div>
            {/* Search bar */}
            <div className="p-[33px]">
                <SearchBar  friends={friends} onSearch={handleSearch} />
                {selectedFriend && <p>Selected Friend: {selectedFriend.friendName}</p>}
            </div>
            {/* Last chat*/}
            <div>
                <div className="flex items-center justify-between pl-[33px] pr-[78px]">
                    <h2 className="text-[15px] text-base text-[#6a65bf]">Last chats</h2>
                    <div className="w-[38px] h-[38px] flex items-center justify-center bg-[#7dd6b4] rounded-xl">
                        <i className="fas fa-plus text-white"></i>
                    </div>
                </div>
            </div>
            <div className="pl-[28px] pt-[28px] pr-[33px]">
                <div className="overflow-y-auto max-h-[400px]">
                    <ul>
                        {recentMessages.map((user, index) => (
                            <a key={index} href={`/chat/${user.user_id}`}>
                                <li className="flex items-center hover:bg-gray-100 relative w-[376px] h-[93px]  pl-[33px] py-[20px] space-x-[20px] rounded-2xl">
                                    <img src={`/images/${user.avatar}`} alt="Avatar" className="w-[48px] h-[48px] rounded-full object-cover"/>
                                    <div className="flex flex-col flex-grow">
                                        <div className="flex justify-between items-center">
                                            <div className="flex items-center">
                                                <p className="text-[#6a65bf] font-bold text-lg">{user.username.length > 0 ? user.username : 'N/A'}</p>
                                                <p className="text-gray-400 text-sm font-bold absolute top-[50%] right-[22px] transform translate-y-[-50%]">
                                                    {formatDate(user.created_at)}
                                                </p>
                                            </div>
                                        </div>
                                        <p className="text-gray-400 text-sm font-bold">
                                            {user.message.length > 25
                                                ? user.message.substring(0, user.message.lastIndexOf(' ', 25)) + "   ..."
                                                : user.message}
                                        </p>
                                    </div>
                                </li>
                            </a>
                        ))}
                    </ul>
                </div>
            </div>
        </div>
    );
}


