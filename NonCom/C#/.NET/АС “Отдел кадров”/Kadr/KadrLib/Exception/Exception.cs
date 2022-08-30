using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace KadrLib.Exception
{
   public class Exception : System.Exception
    {

        public Exception()
        {
        }

        public Exception(string message) : base(message)
        {
        }

        public Exception(string message, System.Exception inner) : base(message, inner)
        {
        }

       
    }
}
