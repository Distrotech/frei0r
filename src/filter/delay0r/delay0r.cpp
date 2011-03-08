#include "frei0r.hpp"

#include <algorithm>
#include <vector>
#include <utility>
#include <cassert>

class delay0r : public frei0r::filter
{
public:
  delay0r(unsigned int width, unsigned int height)
  {
    delay = 0.0;
    register_param(delay,"DelayTime","the delay time");
  }
  
  virtual void update()
  {
    unsigned int* reusable = 0;
    // remove old frames
    for (std::list< std::pair< double, unsigned int* > >::iterator i=buffer.begin(); i != buffer.end(); ++i)
      {
	if (i->first < (time - delay))
	  {
	    // remove me
	    if (reusable != 0)
	      delete[] i->second;
	    else
	      reusable = i->second;

	    i=buffer.erase(i);
	  }
      }
    
    // add new frame
    if (reusable == 0)
      reusable = new unsigned int[width*height];

    std::copy(in, in+width*height,reusable);
    buffer.push_back(std::make_pair(time,reusable));

    // copy best
    unsigned int* best_data=0;
    double best_time=0;

    assert (buffer.size() >0);
    for (std::list< std::pair< double, unsigned int* > >::iterator i=buffer.begin(); i != buffer.end(); ++i)
      {
	if (best_data==0 || (i->first < best_time))
	  {
	    best_time=i->first;
	    best_data=i->second;
	  }
      }

    assert(best_data != 0);
    std::copy(best_data,best_data+width*height,out);
  }
  
private:
  f0r_param_double delay;
  std::list< std::pair< double, unsigned int* > > buffer;
};


frei0r::construct<delay0r> plugin("delay0r",
				  "video delay",
				  "Martin Bayer",
				  0,1);

