import React from 'react';

const Sidebar = ({auth}) => {
    return (
        <div className="w-full md:w-[104px] bg-white flex flex-col justify-center items-center border-none border-gray-400 pt-[12px]">
            {/* Logo content */}
            <div className="p-4 md:absolute md:top-7">
                <img src={`/images/logo.svg`} alt="Logo" className="w-[48px] h-[48px]" />
            </div>
            <div className="p-4">
                {/* Small avatar content */}
                <img src={`/images/${auth.avatar}`} alt="Avatar" className="w-[48px] h-[48px] rounded-full object-cover" />
            </div>
            <div className="p-4 flex flex-col items-center">
                {/* Buttons content */}
                <button className="bg-white text-gray-400 px-4 py-2 mb-[30px] w-37 h-37">
                    <a href={`../user/userprofile/`} className="SideBar-Link SideBar-Icon">
                        <i className="fas fa-circle-user"></i>
                    </a>
                </button>
                <button className="bg-white text-gray-400 px-4 py-2 mb-[30px] w-37 h-37">
                    <a href={`../newsfeed/home`} className="SideBar-Link SideBar-Icon">
                        <i className="fas fa-users"></i>
                    </a>
                </button>
                <button className="bg-white text-gray-400 px-4 py-2 mb-[30px] w-37 h-37">
                    <a href={`../chat`} className="SideBar-Link SideBar-Icon">
                        <i className="fas fa-comments"></i>
                    </a>
                </button>
                <button className="bg-white text-gray-400 px-4 py-2 w-37 h-37">
                    <a href={`../user/editprofile/${auth.id}`} className="SideBar-Link SideBar-Icon">
                        <i className="fas fa-regular fa-gear"></i>
                    </a>
                </button>
            </div>
        </div>
    );
};

export default Sidebar;
