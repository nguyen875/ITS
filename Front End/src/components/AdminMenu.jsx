import { Outlet, Link, useLocation } from "react-router-dom";
import AccountCircleOutlinedIcon from '@mui/icons-material/AccountCircleOutlined';
import LocalLibraryOutlinedIcon from '@mui/icons-material/LocalLibraryOutlined';
import DashboardIcon from '@mui/icons-material/Dashboard';
import NotificationsOutlinedIcon from '@mui/icons-material/NotificationsOutlined';
import SearchOutlinedIcon from '@mui/icons-material/SearchOutlined';
import SettingsOutlinedIcon from '@mui/icons-material/SettingsOutlined';
import LogoutOutlinedIcon from '@mui/icons-material/LogoutOutlined';
import MenuIcon from '@mui/icons-material/Menu';
import CloseIcon from '@mui/icons-material/Close';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import { useState } from 'react';
import UserManagement from "./UserManagement";

export default function AdminLayout() {
  const { pathname } = useLocation();
  const [sidebarOpen, setSidebarOpen] = useState(false);
  
  const isUser = pathname.startsWith("/admin-dashboard/user-management") || pathname === "/admin-dashboard";
  const isCourse = pathname.startsWith("/admin-dashboard/course-management");

  const navItems = [
    {
      to: "/admin-dashboard/user-management",
      icon: AccountCircleOutlinedIcon,
      label: "User Management",
      active: isUser,
      description: "Manage users and permissions"
    },
    {
      to: "/admin-dashboard/course-management",
      icon: LocalLibraryOutlinedIcon,
      label: "Course Management",
      active: isCourse,
      description: "Create and edit courses"
    }
  ];

  return (
    <div className="min-h-screen bg-slate-50">
      {/* Top Navigation Bar */}
      <header className="top-0 left-0 right-0 h-16 bg-white border-b border-slate-200 z-50 shadow-sm">
        <div className="h-full px-4 lg:px-6 flex items-center justify-between">
          {/* Left Section */}
          <div className="flex items-center gap-4 ">
            <button
              onClick={() => setSidebarOpen(!sidebarOpen)}
              className="p-2 hover:bg-slate-100 rounded-lg transition-colors lg:hidden"
            >
              <MenuIcon className="text-slate-600" />
            </button>
            
            <div className="flex items-center gap-3 !ml-5">
              <div className="w-9 h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                <DashboardIcon className="text-white text-lg" />
              </div>
              <div className="hidden sm:block">
                <h1 className="font-bold text-slate-800 text-base">ITS Management</h1>
                <p className="text-xs text-slate-500">Admin Portal</p>
              </div>
            </div>
          </div>

          {/* Right Section */}
          <div className="flex items-center gap-2">
            {/* <button className="relative p-2 hover:bg-slate-100 rounded-lg transition-colors">
              <NotificationsOutlinedIcon className="text-slate-600" fontSize="small" />
              <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
            </button> */}

            <div className="hidden sm:flex items-center gap-2 ml-2 pl-3 !mr-5">
              <div className="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                A
              </div>
              <div className="hidden lg:block">
                <p className="text-sm font-medium text-slate-700">Admin</p>
                <p className="text-xs text-slate-500">Administrator</p>
              </div>
              <KeyboardArrowDownIcon className="text-slate-400" fontSize="small" />
            </div>
          </div>
        </div>
      </header>

      {/* Mobile Sidebar Backdrop
      {sidebarOpen && (
        <div 
          className="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
          onClick={() => setSidebarOpen(false)}
        />
      )} */}

      {/* Sidebar */}
      <div className="h-screen flex">
        <div className="flex w-[20%] shadow-sm h-[100%] flex-col">
          {/* Navigation */}
          <nav className="p-4 overflow-y-auto flex flex-col gap-2">
            <p className="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3 px-3 !mt-5">
              Main Menu
            </p>

            <div className="space-y-1 flex flex-col gap-3">
              {navItems.map((item) => (
                <Link
                  key={item.to}
                  to={item.to}
                  onClick={() => setSidebarOpen(false)}
                  className={`
                    block px-3 py-3 rounded-lg transition-all duration-200 group
                    ${item.active 
                      ? "bg-indigo-50 border border-indigo-200" 
                      : "hover:bg-slate-50 border border-transparent"
                    }
                  `}
                >
                  <div className="flex items-center gap-3">
                    <div className={`
                      w-10 h-10 rounded-lg flex items-center justify-center transition-all
                      ${item.active 
                        ? "bg-gradient-to-br from-indigo-600 to-purple-600 shadow-lg shadow-indigo-200/50" 
                        : "bg-slate-100 group-hover:bg-indigo-100"
                      }
                    `}>
                      <item.icon fontSize="small" className={item.active ? "text-white" : "text-slate-600 group-hover:text-indigo-600"} />
                    </div>
                    <div className="flex-1">
                      <p className={`text-sm font-semibold ${item.active ? "text-indigo-700" : "text-slate-700"}`}>
                        {item.label}
                      </p>
                      <p className="text-xs text-slate-500 mt-0.5">
                        {item.description}
                      </p>
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          </nav>

          {/* Sidebar Footer */}
          <div className="p-4 border-t border-slate-200 !mt-2">
            <button className="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-red-50 transition-all group !mt-2 cursor-pointer">
              <div className="w-10 h-10 rounded-lg bg-slate-100 group-hover:bg-red-100 flex items-center justify-center transition-all">
                <LogoutOutlinedIcon fontSize="small" className="text-slate-600 group-hover:text-red-600" />
              </div>
              <div className="flex-1 text-left">
                <p className="text-sm font-semibold text-slate-700 group-hover:text-red-600">Logout</p>
                <p className="text-xs text-slate-500">Sign out of account</p>
              </div>
            </button>
          </div>
        </div>
        <div className="w-[70%] !mx-auto !mt-5">
         <UserManagement />
        </div>
      </div>
    </div>
  );
}