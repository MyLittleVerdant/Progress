using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using HiReD.Models;

namespace HiReD
{
    public class Complete
    {
        public int id { get; set; }
        public string Department { get; set; }
        public string Post { get; set; }
        public string Status { get; set; }
        public string Info { get; set; }

        public virtual Interview Interview { get; set; }

       public Complete(Recruitment copy)
        {
            id = copy.id;
            Department = copy.Department;
            Post = copy.Post;
            Status = copy.Status;
            Interview = copy.Interview;
        }
    }
}