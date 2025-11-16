import HighlightOffIcon from '@mui/icons-material/HighlightOff';

export default function ErrorMessage({error}) {
    return (
        <div className="flex gap-2 w-fit bg-[#fee2e2] rounded-3xl !py-1 !px-2">
            <HighlightOffIcon sx={{
                                    width: 20,
                                    color: "#b91c1c",
                                 }} />
            <p className="font-bold text-xs text-[#b91c1c] !my-auto">{error}</p>
        </div>
    )
}