import { Head, Link } from "@inertiajs/react";
import moment from "moment";

const Days = ({days = []}) => {

    const format = (date) => {
        return moment(date).format("MMM Do");
    }

    return (
        <>
            <Head title="Days"></Head>
            <div className="min-h-screen bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center">
                <div className="container mx-auto p-3">
                    <div className="md:w-2/3 rounded mx-auto bg-gray-100 p-3 md:p-5">
                        <h4 className="text-xl font-bold">Event Days</h4>
                        <p className="mb-4 text-xs">Select a Day to proceed</p>
                        <div className="grid grid-cols-3 md:grid-cols-6 gap-4">
                            {
                                days.map(item => {
                                    return <Link href={'/seats/' + item.day} className="w-18 bg-white h-24 cursor-pointer shadow-sm rounded font-bold text-blue-500 flex items-center justify-center">
                                        {format(item.event_date)}
                                    </Link>
                                })
                            }
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Days;
