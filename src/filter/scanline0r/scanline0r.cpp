#include "frei0r.hpp"

#include <algorithm>

class scanline0r : public frei0r::filter
{
public:
  scanline0r(unsigned int width, unsigned int height)
  {
    //register_param(hsync,"HSync","the hsync offset");
  }
  
  virtual void update()
  {
    for (unsigned int line=0; line < height; line+=4)
      {
	std::copy(in+line*width,in+(line+1)*width,out+(line*width));
	std::fill(out+(line+1)*width,out+(line+5)*width,0x00000000);
      }
  }
  
private:
  //f0r_param_double hsync;
};


frei0r::construct<scanline0r> plugin("scanline0r",
				     "interlaced blak lines",
				     "Martin Bayer",
				     0,1);

