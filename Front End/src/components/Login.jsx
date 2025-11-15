import "../styles/Fonts.css"

export default function Login() {
    return (
        <section className="montserrat-custom h-full w-full flex items-center justify-center  bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500">
            <form className="w-[30%] flex flex-col gap-10 bg-white !p-10 rounded-2xl">
                <h1 className="text-center font-bold text-3xl text-[#2c2c2c]">Login</h1>
                <div className="flex flex-col gap-3 text-sm">
                    <label className="font-light">Username</label>
                    <input className="w-full border-b !px-2 !py-3" placeholder="Type your email" />
                </div>

                <div className="flex flex-col gap-3 text-sm">
                    <label className="font-light">Password</label>
                    <input type="password" className="w-full border-b !px-2 !py-3" placeholder="Type your password" />
                    <p className="font-light text-xs !ml-auto hover:underline cursor-pointer">Forgot password?</p>
                </div>

                <button className="!py-3 rounded-2xl font-bold text-base text-white bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 hover:[background:linear-gradient(to_right,#76a9fa,#b28dff,#ff7ac6)]">Login</button>

                <p className="text-xs text-center">Don't have an account? Sign up <span className="text-[#ec4899] hover:underline hover:text-[#db2777] cursor-pointer">here</span></p>
            </form>
        </section>
    );
}