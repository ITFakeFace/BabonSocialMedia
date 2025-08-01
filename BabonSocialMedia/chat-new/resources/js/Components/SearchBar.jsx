import React, { useState } from 'react';

const SearchBar = ({ onSearch, friends }) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedFriend, setSelectedFriend] = useState(null);

    const handleInputChange = (event) => {
        const searchTerm = event.target.value;
        setSearchTerm(searchTerm);
        setSelectedFriend(null);
        onSearch(searchTerm);
    };

    const handleFriendSelect = (friend) => {
        setSelectedFriend(friend);
        setSearchTerm('');
    };

    const handleFormSubmit = (event) => {
        event.preventDefault();
    };

    // Filter friends based on search term
    const filteredFriends = friends.filter((friend) =>
        friend.friendName.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <div className="relative">
            <input
                type="text"
                className="text-lg w-[376px] h-[58px] px-[20px] border border-gray-300 bg-gray-100 rounded-2xl pr-10"
                placeholder="Search"
                value={searchTerm}
                onChange={handleInputChange}
            />
            <span className="absolute inset-y-0 right-[40px] flex items-center">
    <i className="fas fa-search text-gray-400 w-[23px] "></i>
  </span>
            {searchTerm.length > 0 && (
                <div
                    id="dropdownMenu"
                    className="absolute mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-[376px] max-h-[200px] overflow-y-auto z-10"
                >
                    <ul className="py-2 text-sm text-[#6a65bf]">
                        {filteredFriends.map((friend) => (
                            <li key={friend.friendName}>
                                <a
                                    href={`/chat/${friend.userID}`}
                                    className="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white flex items-center"
                                    onClick={() => handleFriendSelection(friend.friendName)}
                                >
                                    <img
                                        src={`/images/${friend.friendAvatar}`}
                                        alt={`/images/default`}
                                        className="w-6 h-6 rounded-full mr-2 object-fit"
                                    />
                                    <span>{friend.friendName}</span>
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
};

export default SearchBar;
