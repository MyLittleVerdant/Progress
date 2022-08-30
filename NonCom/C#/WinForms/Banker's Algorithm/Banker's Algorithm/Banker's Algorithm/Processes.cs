using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Banker_s_Algorithm
{
    class Processes
    {
        public char name;
        public int has;
        public int max;
        public int need;
        public string done;

        public Processes()
        {
            name = ' ';
            has = 0;
            max = 0;
            need = 0;
            done = "none";
        }

        public Processes(Processes other)
        {
            name = other.name;
            has = other.has;
            max = other.max;
            need = other.need;
            done = other.done;

        }
    }
}
