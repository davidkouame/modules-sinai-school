export default function auth({ next, router, cookies }) {
    console.log("ndjsndjsndnsd");
    if (!cookies.get('userId')) {
      return router.push({ name: 'login' });
    }
    
    console.log("ndjsndjsndnsd");
    return next();
  }