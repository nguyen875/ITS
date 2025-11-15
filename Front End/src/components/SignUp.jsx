import "../styles/Fonts.css"
import teacher from "../assets/image/teacher.svg"
import studentRole from "../assets/image/student.svg"
import { useState } from "react"
export default function SignUp() {
    const [tutor, setTutor] = useState(false);
    const [student, setStudent] = useState(false);

    function clickTutor() {
        setStudent(false);
        setTutor(true);
    }

    function clickStudent() {
        setStudent(true);
        setTutor(false)
    }

    return (
        <section className="montserrat-custom h-fit w-full flex flex-col !py-10 items-center justify-center  bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500">
            <h1 className="text-[40px] font-bold text-white">Choose a role!</h1>
            <div className={`flex gap-10 items-center justify-center !mb-10`}>
                <div onClick={clickTutor} className={`flex flex-col w-[30%] !p-6 rounded-3xl ${tutor ? "bg-gradient-to-br from-blue-500 via-cyan-400 to-orange-400" : "bg-white"} transition-transform duration-300 ease-in-out hover:scale-110`}>
                    <img className="w-[150px]" src={teacher} alt="Teacher Logo" />
                    <p className="text-center">Tutor</p>
                </div>
        
                <div onClick={clickStudent} className={`flex flex-col w-[30%] !p-6 rounded-3xl ${student ? "bg-gradient-to-br from-blue-500 via-cyan-400 to-orange-400" : "bg-white"} transition-transform duration-300 ease-in-out hover:scale-110`}>
                    <img className="w-[150px]" src={studentRole} alt="Student Logo" />
                    <p className="text-center">Student</p>
                </div>
            </div>

            <form className="w-[30%] flex flex-col gap-10 bg-white !px-10 !py-5 rounded-2xl">
                <h1 className="text-center font-bold text-3xl text-[#2c2c2c]">Sign Up</h1>
                <div className="flex flex-col gap-3 text-sm">
                    <label className="font-light">Username</label>
                    <input className="w-full border-b !px-2 !py-3" placeholder="Type your email" />
                </div>

                <div className="flex flex-col gap-3 text-sm">
                    <label className="font-light">Email</label>
                    <input className="w-full border-b !px-2 !py-3" placeholder="Type your email" />
                </div>

                <div className="flex flex-col gap-3 text-sm">
                    <label className="font-light">Password</label>
                    <input type="password" className="w-full border-b !px-2 !py-3" placeholder="Type your password" />
                </div>

                <div className="flex flex-col gap-3 text-sm">
                    <label className="font-light">Confirm password</label>
                    <input type="password" className="w-full border-b !px-2 !py-3" placeholder="Type your password" />
                </div>

                <button className="!py-3 rounded-2xl font-bold text-base text-white bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 hover:[background:linear-gradient(to_right,#76a9fa,#b28dff,#ff7ac6)]">Sign up</button>

                <p className="text-xs text-center">Have an account? Log in <span className="text-[#ec4899] hover:underline hover:text-[#db2777] cursor-pointer">here</span></p>
            </form>
        </section>
    );
}