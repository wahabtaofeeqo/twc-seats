import { Head, Link } from "@inertiajs/react";
import moment from "moment";

const Thanks = ({days = []}) => {

    return (
        <>
            <Head title="Thank You"></Head>
            <div className="min-h-screen bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center">
                <div className="container mx-auto p-3">
                    <div className="md:w-1/3 rounded mx-auto text-center bg-gray-100 p-3 md:p-5">
                        <h4 className="text-2xl font-bold mb-2">Please wait while we confirm your booking...</h4>
                        <p class="mb-5 text-sm">
                            Join us in celebrating 120 years of Polo, with an exceptional calibre of members, at The Lagos Polo Club the premier sporting Polo Club in Nigeria.
                        </p>
                        <a href='/' className='bg-yellow-500 p-2 px-3 rounded text-white'>Back to Home</a>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Thanks;
