<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use app\Models\History;
use Illuminate\Support\Facades\Auth;

class BusinessOwnerController extends Controller
{
    /**
     * Display the dashboard for business owners.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Define the locations you want to filte
        $locations = ['Cebu City', 'Mandaue City', 'Talisay City', 'Lapu-Lapu City', 'Naga City', 'Minglanilla City', 'Toledo City', 'Carcar', 'Asturias', 'Dumanjug', 'Barili', 'Danao'];
        
        // Initialize an array to store the counts
        $listingsCount = [];

        // Loop through the locations and get the count for each
        foreach ($locations as $location) {
            // Count listings for the current location
            $listingsCount[$location] = Listing::where('location', 'LIKE', '%' . $location . '%')->count();
        }

         // Return the count to the view
        return view('dashboard.business', compact('listingsCount'));
    }

    public function showByLocation($location)
    {
        // Fetch all listings for the specific location
        $listings = Listing::with('owner')->where('location', 'LIKE', '%' . $location . '%')->get();

        // Pass the listings and the location to the view
        return view('place.showByLocation', compact('listings', 'location'));
    }

    public function detail($listingID)
    {
        $listing = Listing::with('owner')->findOrFail($listingID);
        return view('place.detail', compact('listing'));
    }
    public function negotiations()
    {
        return view('negotiations.business');
    }
    public function bookinghistory()
    {
        $bhistory = History::where('renterID', Auth::id())->get();
        return view('business_owner.bookinghistory', compact('bhistory'));
    }
    public function feedback()
    {
        return view('feedback.business');
    }
    

    // Add additional methods specific to business owners here
    // For example, methods to manage businesses, view reports, etc.
}
